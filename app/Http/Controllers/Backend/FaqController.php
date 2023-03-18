<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\MainHelper;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class FaqController extends Controller
{


    public function __construct()
    {
        $this->middleware('can:faqs-create', ['only' => ['create', 'store']]);
        $this->middleware('can:faqs-read', ['only' => ['show', 'index']]);
        $this->middleware('can:faqs-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:faqs-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $faqs = Faq::where(function ($q) use ($request) {
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
            if ($request->q != null) {
                $q->where('question', 'LIKE', '%' . $request->q . '%')->orWhere(
                    'answer',
                    'LIKE',
                    '%' . $request->q . '%'
                );
            }
        })->orderBy('order', 'ASC')->orderBy('id', 'DESC')->paginate(100);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $this->validateFaq($request);

        $faq = new Faq();

        $this->saveFaq($request, $faq);

        toastr()->success(__('utils/toastr.process_success_message'), __('utils/toastr.successful_process_message'));
        return redirect()->route('admin.faqs.index');
    }

    public function show(Faq $faq)
    {
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $this->validateFaq($request);

        $this->saveFaq($request, $faq);

        toastr()->success(__('utils/toastr.process_success_message'), __('utils/toastr.successful_process_message'));
        return redirect()->route('admin.faqs.index');
    }

    public function destroy(Faq $faq)
    {
        if (!auth()->user()->can('faqs-delete')) {
            abort(403);
        }
        $faq->delete();
        toastr()->success(__('utils/toastr.process_success_message'), __('utils/toastr.successful_process_message'));
        return redirect()->route('admin.faqs.index');
    }


    public function order(Request $request)
    {
        foreach ($request->order as $key => $value) {
            Faq::where('id', $value)->update(['order' => $key]);
        }
    }

    private function validateFaq(Request $request)
    {
        $rules = RuleFactory::make([
            '%question%' => 'required',
            '%answer%' => 'required',
            'is_featured' => 'required|in:0,1',
        ]);

        $request->validate($rules);
    }

    private function saveFaq(Request $request, Faq $faq)
    {
        $faq->user_id = auth()->user()->id;
        $faq->is_featured = $request->is_featured;

        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $faq->translateOrNew($key)->question = $request->{$key}['question'];
            $faq->translateOrNew($key)->answer = $request->{$key}['answer'];
        }

        $faq->save();
    }

}
