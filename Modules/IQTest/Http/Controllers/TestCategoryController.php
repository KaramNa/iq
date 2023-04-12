<?php

namespace Modules\IQTest\Http\Controllers;

use App\Helpers\MainHelper;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\IQTest\Models\TestCategory;

class TestCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:test-categories-create', ['only' => ['create', 'store']]);
        $this->middleware('can:test-categories-read', ['only' => ['show', 'index']]);
        $this->middleware('can:test-categories-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:test-categories-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $categories = TestCategory::where(function ($q) use ($request) {
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
            if ($request->q != null) {
                $q->whereTranslationLike('name', '%' . $request->q . '%');
            }
        })->withCount(['tests'])->orderBy('id', 'DESC')->paginate();

        return view('iqtest::admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('iqtest::admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->validateCategory($request);

        $category = new TestCategory();
        $category->user_id = auth()->user()->id;

        $this->saveCategory($request, $category);

        toastr()->success(
            __('utils/toastr.category_store_success_message'),
            __('utils/toastr.successful_process_message')
        );
        return redirect()->route('admin.test-categories.index');
    }

    public function edit($id)
    {
        $category = TestCategory::find($id);
        return view('iqtest::admin.categories.edit', compact('category'));

    }

    public function update(Request $request, $id)
    {
        $category = TestCategory::find($id);

        $this->validateCategory($request);

        $this->saveCategory($request, $category);

        toastr()->success(
            __('utils/toastr.category_update_success_message'),
            __('utils/toastr.successful_process_message')
        );

        return redirect()->route('admin.test-categories.index');

    }

    public function destroy($id)
    {
        $category = TestCategory::find($id);

        $category->delete();

        toastr()->success(
            __('utils/toastr.category_destroy_success_message'),
            __('utils/toastr.successful_process_message')
        );

        return redirect()->route('admin.test-categories.index');

    }

    private function validateCategory(Request $request): void
    {
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $translated_data = $request->$key;
            if ($translated_data['name']) {
                $translated_data['slug'] = Str::slug($request->{$key}['name'], '-', null);
                $request->merge([
                    $key => $translated_data
                ]);
            }
        }

        $rules = RuleFactory::make([
            '%name%' => 'required|unique:test_category_translations,name,' . $request->test_category . ',test_category_id',
            '%description%' => 'required|max:100000',
            '%meta_description%' => 'required|max:100000',
        ]);

        $request->validate($rules);
    }

    private function saveCategory(Request $request, TestCategory $category): void
    {
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($request->{$key}['name']) {
                $category->translateOrNew($key)->name = $request->{$key}['name'];
                $category->translateOrNew($key)->description = $request->{$key}['description'];
                $category->translateOrNew($key)->slug = $request->{$key}['slug'];
                $category->translateOrNew($key)->meta_description = $request->{$key}['meta_description'];
            }
        }

        $category->save();

        if ($request->hasFile('image')) {
            $image = $category->addMedia($request->image)->toMediaCollection('image');
            $category->update(['image' => $image->id . '/' . $image->file_name]);
        }

        MainHelper::move_media_to_model_by_id($request->temp_file_selector, $category, "description");

    }
}
