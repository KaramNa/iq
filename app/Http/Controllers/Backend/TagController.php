<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tags-create', ['only' => ['create', 'store']]);
        $this->middleware('can:tags-read', ['only' => ['show', 'index']]);
        $this->middleware('can:tags-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:tags-delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $tags = Tag::where(function ($q) use ($request) {
            if ($request->id != null) {
                $q->where('id', $request->id);
            }
            if ($request->q != null) {
                $q->whereTranslationLike('name', '%' . $request->q . '%');
            }
        })->orderBy('id', 'DESC')->paginate(100);
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $this->validateTag($request);

        $tag = new Tag();

        $this->saveTag($request, $tag);

        toastr()->success('تمت العملية بنجاح', 'عملية ناجحة');

        return redirect()->route('admin.tags.index');
    }


    public function edit($id)
    {
        $tag = Tag::find($id);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, $id)
    {
        $category = Tag::find($id);

        $this->validateTag($request);

        $this->saveTag($request, $category);

        toastr()->success('تمت العملية بنجاح', 'عملية ناجحة');
        return redirect()->route('admin.tags.index');
    }

    public function destroy($id)
    {
        Tag::find($id)->delete();
        toastr()->success('تمت العملية بنجاح');
        return redirect()->back();
    }

    private function validateTag(Request $request): void
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
            '%name%' => 'required|unique:tag_translations,name,' . $request->tag . ',tag_id',
        ]);

        $request->validate($rules);
    }

    private function saveTag(Request $request, Tag $tag): void
    {
        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($request->{$key}['name']) {
                $tag->translateOrNew($key)->name = $request->{$key}['name'];
                $tag->translateOrNew($key)->slug = $request->{$key}['slug'];
            }
        }
        $tag->save();
    }
}
