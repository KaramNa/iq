<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\MainHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:categories-create', ['only' => ['create', 'store']]);
        $this->middleware('can:categories-read', ['only' => ['show', 'index']]);
        $this->middleware('can:categories-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:categories-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $categories = Category::where(function ($q) use ($request) {
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
            if ($request->q != null) {
                $q->whereTranslationLike('name', '%' . $request->q . '%');
            }
        })->withCount(['articles'])->orderBy('id', 'DESC')->paginate();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->validateCategory($request);

        $category = new Category();
        $category->user_id = auth()->user()->id;

        $this->saveCategory($request, $category);

        toastr()->success(
            __('utils/toastr.category_store_success_message'),
            __('utils/toastr.successful_process_message')
        );
        return redirect()->route('admin.categories.index');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $this->validateCategory($request);

        $this->saveCategory($request, $category);

        toastr()->success(
            __('utils/toastr.category_update_success_message'),
            __('utils/toastr.successful_process_message')
        );

        return redirect()->route('admin.categories.index');
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        toastr()->success(
            __('utils/toastr.category_destroy_success_message'),
            __('utils/toastr.successful_process_message')
        );

        return redirect()->route('admin.categories.index');
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
            '%name%' => 'required|unique:category_translations,name,' . $request->category . ',category_id',
            '%description%' => 'required|max:100000',
            '%meta_description%' => 'required|max:100000',
        ]);

        $request->validate($rules);
    }

    private function saveCategory(Request $request, Category $category): void
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
