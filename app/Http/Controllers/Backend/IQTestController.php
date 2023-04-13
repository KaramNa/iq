<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\MainHelper;
use App\Models\Test;
use App\Models\TestCategory;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class IQTestController extends Controller
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
        if ($request->test_category_id != null) {
            $category = TestCategory::find($request->test_category_id);
            $tests = $category->tests()->translatedIn($lang)->orderBy('id', 'DESC')->paginate();
        } else {
            $tests = Test::where(function ($q) use ($request) {
                if ($request->id != null) {
                    $q->where('id', $request->id);
                }

                if ($request->q != null) {
                    $q->whereTranslationLike('title', '%' . $request->q . '%');
                }
            })->with(['testCategory'])->translatedIn($lang)->orderBy('id', 'DESC')->paginate();
        }

        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $categories = TestCategory::orderBy('id', 'DESC')->get();
        return view('admin.tests.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validateTest($request);

        $test = new Test();

        $this->saveTest($request, $test);

        toastr()->success(
            __('utils/toastr.article_store_success_message'),
            __('utils/toastr.successful_process_message')
        );

        return redirect()->route('admin.tests.index');
    }

    public function show($id)
    {
        return view('show');
    }

    public function edit($id)
    {
        $test = Test::find($id);
        $categories = TestCategory::orderBy('id', 'DESC')->get();
        return view('admin.tests.edit', compact('test', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $test = Test::find($id);

        $this->validateTest($request);

        $this->saveTest($request, $test);

        toastr()->success(
            __('utils/toastr.article_update_success_message'),
            __('utils/toastr.successful_process_message')
        );
        return redirect()->route('admin.tests.index');
    }

    public function destroy($id)
    {
        $test = Test::find($id);
        $test->delete();
        toastr()->success(
            __('utils/toastr.article_destroy_success_message'),
            __('utils/toastr.successful_process_message')
        );
        return back();
    }

    private function validateTest(Request $request): void
    {
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $translated_data = $request->$key;
            if ($translated_data['slug']) {
                $translated_data['slug'] = Str::slug($request->{$key}['slug'], '-', null);
            } else {
                $translated_data['slug'] = Str::slug($request->{$key}['title'], '-', null);
            }
            $request->merge([
                $key => $translated_data
            ]);
        }

        $rules = RuleFactory::make([
            'ar.title' => 'required_without:en.title',
            'en.title' => 'required_without:ar.title',
            'ar.slug' => 'required_with:ar.title|max:60|unique:test_translations,slug,' . $request->test . ',test_id',
            'en.slug' => 'required_with:en.title|max:60|unique:test_translations,slug,' . $request->test . ',test_id',
            'ar.description' => 'required_with:ar.title|max:100000',
            'en.description' => 'required_with:en.title|max:100000',
            'ar.meta_description' => 'required_with:ar.title|max:100000',
            'en.meta_description' => 'required_with:en.title|max:100000',
            'test_category_id' => 'required',
            'published' => 'required|in:0,1',
            'score' => 'required|numeric',
            'duration' => 'required|numeric',
        ]);


        $request->validate($rules);
    }

    private function saveTest(Request $request, Test $test)
    {
        $test->user_id = auth()->user()->id;
        $test->published = $request->published;
        $test->score = $request->score;
        $test->duration = $request->duration;
        $test->test_category_id = $request->test_category_id;
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($request->{$key}['title']) {
                $test->translateOrNew($key)->title = $request->{$key}['title'];
                $test->translateOrNew($key)->description = $request->{$key}['description'];
                $test->translateOrNew($key)->slug = $request->{$key}['slug'];
                $test->translateOrNew($key)->meta_description = $request->{$key}['meta_description'];
            }

        }
        $test->save();


        MainHelper::move_media_to_model_by_id($request->temp_file_selector, $test, 'description');

        if ($request->hasFile('image')) {
            $image = $test->addMedia($request->image)->toMediaCollection('image');
            $test->update(['image' => $image->id . '/' . $image->file_name]);
        }
    }

    public function getData()
    {
        $data = [
            'labels' => ['40', '50', '60', '70', '80', '90', '100', '110', '120', '130', '140', '150', '160'],
            'datasets' => [
                [
                    'label' => 'My First Dataset',
                    'data' => [0.01, 0.2, 1, 5, 10, 50, 50, 80, 90, 95, 99, 99.9, 99.9],
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'lineTension' => 0.1
                ]
            ]
        ];

        return response()->json($data);
    }
}
