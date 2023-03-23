<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\MainHelper;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:articles-create', ['only' => ['create', 'store']]);
        $this->middleware('can:articles-read', ['only' => ['show', 'index']]);
        $this->middleware('can:articles-update', ['only' => ['edit', 'update']]);
        $this->middleware('can:articles-delete', ['only' => ['delete']]);
    }


    public function index(Request $request)
    {
        $lang = $request->lang ?? app()->getLocale();
        if ($request->category_id != null) {
            $categroy = Category::find($request->category_id);
            $articles = $categroy->articles()->translatedIn($lang)->orderBy('id', 'DESC')->paginate();
        } else {
            $articles = Article::where(function ($q) use ($request) {
                if ($request->id != null) {
                    $q->where('id', $request->id);
                }

                if ($request->q != null) {
                    $q->whereTranslationLike('title', '%' . $request->q . '%');
                }
            })->translatedIn($lang)->orderBy('id', 'DESC')->paginate();
        }


        return view('admin.articles.index', compact('articles'));
    }


    public function create()
    {
        $tags = Tag::get();
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.articles.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $this->validateArticle($request);

        $article = new Article();

        $article->views = 0;

        $this->saveArticle($request, $article);

        toastr()->success(
            __('utils/toastr.article_store_success_message'),
            __('utils/toastr.successful_process_message')
        );

        return redirect()->route('admin.articles.index');
    }

    public function edit($id)
    {
        $tags = Tag::get();
        $article = Article::find($id);
        $categories = Category::orderBy('id', 'DESC')->get();
        return view('admin.articles.edit', compact('article', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        $this->validateArticle($request);

        $this->saveArticle($request, $article);

        toastr()->success(
            __('utils/toastr.article_update_success_message'),
            __('utils/toastr.successful_process_message')
        );
        return redirect()->route('admin.articles.index');
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        toastr()->success(
            __('utils/toastr.article_destroy_success_message'),
            __('utils/toastr.successful_process_message')
        );
        return back();
    }

    private function validateArticle(Request $request): void
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

        if ($request->has('draft')) {
            $rules = RuleFactory::make([
                'ar.title' => 'required_without:en.title',
                'en.title' => 'required_without:ar.title',
            ]);
        } else {
            $rules = RuleFactory::make([
                'ar.title' => 'required_without:en.title',
                'en.title' => 'required_without:ar.title',
                'ar.slug' => 'required_with:ar.title|max:60|unique:article_translations,slug,' . $request->article . ',article_id',
                'en.slug' => 'required_with:en.title|max:60|unique:article_translations,slug,' . $request->article . ',article_id',
                'ar.description' => 'required_with:ar.title|max:100000',
                'en.description' => 'required_with:en.title|max:100000',
                'ar.meta_description' => 'required_with:ar.title|max:100000',
                'en.meta_description' => 'required_with:en.title|max:100000',
                'category_id' => 'required|array',
                'category_id.*' => 'required|exists:categories,id',
                'is_featured' => 'required|in:0,1',
            ]);
        }

        $request->validate($rules);
    }

    private function saveArticle(Request $request, Article $article)
    {
        $article->user_id = auth()->user()->id;
        $article->is_featured = $request->is_featured;
        if ($request->has('draft')) {
            $article->is_published = 0;
        } else {
            $article->is_published = 1;
        }


        foreach (LaravelLocalization::getSupportedLocales() as $key => $locale) {
            if ($request->{$key}['title']) {
                $article->translateOrNew($key)->title = $request->{$key}['title'];
                $article->translateOrNew($key)->description = $request->{$key}['description'];
                $article->translateOrNew($key)->slug = $request->{$key}['slug'];
                $article->translateOrNew($key)->meta_description = $request->{$key}['meta_description'];
            } else {
                $article->translate($key)?->delete();
            }
        }
        $article->save();

        $article->categories()->sync($request->category_id);

        $article->tags()->sync($request->tag_id);

        MainHelper::move_media_to_model_by_id($request->temp_file_selector, $article, 'description');

        if ($request->hasFile('image')) {
            $image = $article->addMedia($request->image)->toMediaCollection('image');
            $article->update(['image' => $image->id . '/' . $image->file_name]);
        }
    }
}
