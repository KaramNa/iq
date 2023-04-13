<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\MainHelper;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tests-create', ['only' => ['create', 'store']]);
        $this->middleware('can:tests-read', ['only' => ['show', 'index']]);
        $this->middleware('can:tests-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:tests-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $lang = $request->lang ?? app()->getLocale();
        if ($request->test_id != null) {
            $question = Test::find($request->test_id);
            $questions = $question->questions()->translatedIn($lang)->orderBy('id', 'DESC')->paginate();
        } else {
            $questions = Question::where(function ($q) use ($request) {
                if ($request->id != null) {
                    $q->where('id', $request->id);
                }

                if ($request->q != null) {
                    $q->whereTranslationLike('content', '%' . $request->q . '%');
                }
            })->with(['test'])->translatedIn($lang)->orderBy('id', 'DESC')->paginate();
        }

        return view('admin.questions.index', compact('questions'));
    }

    public function create(Request $request)
    {
        $request->validate(['test_id' => "required|exists:tests,id"]);
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $this->validateQuestion($request);

        $question = new Question();

        $this->saveQuestion($request, $question);

        toastr()->success(
            __('utils/toastr.article_store_success_message'),
            __('utils/toastr.successful_process_message')
        );

        return redirect()->route('admin.questions.index', ['test_id' => $question->test->id]);
    }

    public function show($id)
    {
        return view('show');
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $this->validateQuestion($request);

        $this->saveQuestion($request, $question);

        toastr()->success(
            __('utils/toastr.article_update_success_message'),
            __('utils/toastr.successful_process_message')
        );
        return redirect()->route('admin.questions.index', ['test_id' => $question->test->id]);
    }

    public function destroy(Question $question)
    {
        $question?->delete();
        toastr()->success(
            __('utils/toastr.article_destroy_success_message'),
            __('utils/toastr.successful_process_message')
        );
        return back();
    }

    private function validateQuestion(Request $request): void
    {
        $rules = RuleFactory::make([
            '%content%' => 'required',
        ]);

        $request->validate($rules);
    }

    private function saveQuestion(Request $request, Question $question)
    {
        $question->test_id = $request->test_id;
        $question->active = $request->active;
        $question->level = $request->level ?? '';
        $question->weight = $request->weight ?? '';
        $question->type = $request->question_type;

        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($request->{$key}['content']) {
                $question->translateOrNew($key)->content = $request->{$key}['content'];
            } else {
                $question->translate($key)?->delete();
            }
        }
        $question->save();

        MainHelper::move_media_to_model_by_id($request->temp_file_selector, $question, 'description');

        if ($request->hasFile('image')) {
            $image = $question->addMedia($request->image)->toMediaCollection('image');
            $question->update(['image' => $image->id . '/' . $image->file_name]);
        }

        $this->addAnswers($request, $question);
    }

    private function addAnswers($request, $question)
    {
        if ($request->question_type == 'true-or-false') {
            foreach ($question->answers as $answer) {
                $answer->delete();
            }
            $options = [
                'en' => [
                    'true',
                    'false',
                ],
                'ar' => [
                    'صح',
                    'خطأ',
                ]
            ];

            for ($i = 0; $i < 2; $i++) {
                if ($question->answers->count() > $i) {
                    $answer = $question->answers[$i];
                } else {
                    $answer = new Answer();
                }
                $answer->question_id = $question->id;
                $answer->correct = $request->correct_answer == $options['en'][$i] ? 1 : 0;

                foreach (LaravelLocalization::getSupportedLocales() as $code => $locale) {
                    $answer->translateOrNew($code)->content = $options[$code][$i];
                }
                dd($answer);
            }
        } elseif ($request->question_type == 'multiple-choices') {
            $formAnswers = [];
            $formAnswersIds = [];

            for ($i = 0, $count = $request->answers['number_of_answers']; $i <= $count; $i++) {
                if (isset($request->answers['answer_id.' . $i])) {
                    $formAnswersIds[] = $request->answers['answer_id.' . $i];
                }
                foreach ($request->answers as $key => $answer) {
                    if (str_contains($key, $i)) {
                        $formAnswers[$i][str_replace('.' . $i, '', $key)] = $answer;
                    }
                }
            }
            $storedAnswers = $question->answers->pluck('id');
            foreach ($storedAnswers as $id) {
                if (!in_array($id, $formAnswersIds)) {
                    Answer::find($id)->delete();
                }
            }
            foreach ($formAnswers as $key => $formAnswer) {
                $answer_id = $formAnswer['answer_id'];
                if ($answer_id) {
                    $answer = Answer::find($answer_id);
                } else {
                    $answer = new Answer();
                }

                $answer->question_id = $question->id;
                $answer->weight = $formAnswer['weight'] ?? 0;

                $answer->correct = isset($formAnswer['correct']) ? 1 : 0;
                foreach (LaravelLocalization::getSupportedLocales() as $code => $locale) {
                    if (isset($formAnswer[$code . '.content'])) {
                        $answer->translateOrNew($code)->content = $formAnswer[$code . '.content'];
                    } else {
                        $answer->translate($code)?->delete();
                    }
                }
                $answer->save();

                MainHelper::move_media_to_model_by_id(
                    $formAnswer['temp_file_selector'],
                    $answer,
                    'description'
                );

                if (isset($formAnswer['answer_image'])) {
                    $image = $answer->addMedia($formAnswer['answer_image'])->toMediaCollection(
                        'image'
                    );
                    $answer->update(['image' => $image->id . '/' . $image->file_name]);
                }
            }
        }
    }
}
