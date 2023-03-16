<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\MainHelper;
use App\Http\Controllers\Controller;
use App\Models\Page;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:pages-create', ['only' => ['create', 'store']]);
        $this->middleware('can:pages-read', ['only' => ['show', 'index']]);
        $this->middleware('can:pages-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:pages-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $lang = $request->lang ?? app()->getLocale();
        $pages = Page::where(function ($q) use ($request) {
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
            if ($request->q != null) {
                $q->whereTranslationLike('title', '%' . $request->q . '%');
            }
        })->translatedIn($lang)->orderBy('id', 'DESC')->paginate();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $this->validatePage($request);

        $page = new Page();

        $this->savePage($request, $page);


        toastr()->success('تم العملية بنجاح', 'عملية ناجحة');
        return redirect()->route('admin.pages.index');
    }

    public function edit($id)
    {
        $page = Page::find($id);
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);

        $this->validatePage($request);

        $this->savePage($request, $page);

        toastr()->success('تم العملية بنجاح', 'عملية ناجحة');
        return redirect()->route('admin.pages.index');
    }

    public function destroy($id)
    {
        $page = Page::find($id);

        if ($page->removable == 1) {
            $page->delete();
            toastr()->success('تم العملية بنجاح', 'عملية ناجحة');
        } else {
            toastr()->error('عفواً الصفحة غير قابلة للحذف', 'فشلت العملية');
        }
        return redirect()->route('admin.pages.index');
    }

    private function validatePage(Request $request): void
    {
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            $translated_data = $request->$key;
            if ($translated_data['slug']) {
                $translated_data['slug'] = Str::slug($request->{$key}['slug'], '-', null);
                $request->merge([
                    $key => $translated_data
                ]);
            }
        }

        $rules = RuleFactory::make([
            '%title%' => 'required',
            '%slug%' => 'required|max:60|unique:page_translations,slug,' . $request->page . ',page_id',
            '%description%' => 'required|max:100000',
            '%meta_description%' => 'required|max:100000',
            'removable' => 'required|in:0,1'
        ]);

        $request->validate($rules);
    }

    private function savePage(Request $request, Page $page)
    {
        $page->user_id = auth()->user()->id;
        $page->removable = $request->removable;

        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($request->{$key}['title']) {
                $page->translateOrNew($key)->title = $request->{$key}['title'];
                $page->translateOrNew($key)->description = $request->{$key}['description'];
                $page->translateOrNew($key)->slug = $request->{$key}['slug'];
                $page->translateOrNew($key)->meta_description = $request->{$key}['meta_description'];
            }
        }

        $page->save();

        MainHelper::move_media_to_model_by_id($request->temp_file_selector, $page, "description");

        if ($request->hasFile('image')) {
            $image = $page->addMedia($request->image)->toMediaCollection('image');
            $page->update(['image' => $image->id . '/' . $image->file_name]);
        }
    }


}
