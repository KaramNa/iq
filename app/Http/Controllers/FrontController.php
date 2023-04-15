<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Tag;
use App\Models\Test;
use CobraProjects\Arabic\Arabic;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class FrontController extends Controller
{

    public function index(Request $request)
    {
        return view('front.index');
    }

    public function comment_post(Request $request)
    {
        if (auth()->check()) {
            $request->validate([
                'content' => 'required|min:3|max:10000',
            ]);
            ArticleComment::create([
                'user_id' => auth()->user()->id,
                'article_id' => $request->article_id,
                'content' => $request->content,
            ]);
        } else {
            $request->validate([
                'adder_name' => "nullable|min:3|max:190",
                'adder_email' => "nullable|email",
                "content" => "required|min:3|max:10000",
            ]);
            ArticleComment::create([
                'article_id' => $request->article_id,
                'adder_name' => $request->adder_name,
                'adder_email' => $request->adder_email,
                'content' => $request->content,
            ]);
        }
        toastr()->success('تم اضافة تعليقك بنجاح وسيظهر للعامة بعد المراجعة');
        return redirect()->back();
    }

    public function contact_post(Request $request)
    {
        $request->validate([
            'name' => "required|min:3|max:190",
            'email' => "nullable|email",
            'message' => 'required|min:3|max:10000',
            'g-recaptcha-response' => 'recaptcha',
        ]);
//        if (\MainHelper::recaptcha($request->recaptcha) < 0.8) {
//            abort(401);
//        }
        Contact::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'name' => $request->name,
            'email' => $request->email,
            'message' =>/*"قادم من : ".urldecode(url()->previous())."\n\nالرسالة : ".*/ $request->message
        ]);

        toastr()->success(
            __('Your message has been received successfully, and we will contact you as soon as possible.')
        );
        //\Session::flash('message', __("Your Message Has Been Send Successfully And We Will Contact You Soon !"));
        return redirect()->back();
    }

    public function category(Request $request, $slug)
    {
        $category = Category::whereTranslationLike('slug', $slug)->firstOrFail();

        $correctSlug = $category->translate()->slug;
        if ($correctSlug !== $slug) {
            return redirect()->route('category.show', $correctSlug);
        }

        $articles = Article::translatedIn()->where(function ($q) use ($request, $category) {
            if ($request->user_id != null) {
                $q->where('user_id', $request->user_id);
            }

            $q->whereHas('categories', function ($q) use ($request, $category) {
                $q->whereTranslation('category_id', $category->id);
            });
        })->with(['categories', 'tags'])->withCount([
            'comments' => function ($q) {
                $q->where('reviewed', 1);
            }
        ])->orderBy('id', 'DESC')->paginate();
        return view('front.pages.blog', compact('articles', 'category'));
    }

    public function tag(Request $request, $slug)
    {
        $tag = Tag::whereTranslationLike('slug', $slug)->firstOrFail();

        $correctSlug = $tag->translate()->slug;
        if ($correctSlug !== $slug) {
            return redirect()->route('tag.show', $correctSlug);
        }

        $articles = Article::translatedIn()->where(function ($q) use ($request, $tag) {
            if ($request->user_id != null) {
                $q->where('user_id', $request->user_id);
            }

            $q->whereHas('tags', function ($q) use ($request, $tag) {
                $q->whereTranslation('tag_id', $tag->id);
            });
        })->with(['categories', 'tags'])->withCount([
            'comments' => function ($q) {
                $q->where('reviewed', 1);
            }
        ])->orderBy('id', 'DESC')->paginate();

        return view('front.pages.blog', compact('articles', 'tag'));
    }

    public function article(Request $request, $slug)
    {
        $article = Article::whereHas('translations', fn($query) => $query->where('slug', $slug))->firstOrFail();
//        $lang = ArticleTranslation::where('article_id', $article->id)->first('locale')->locale;
        if (!$article->translate()) {
            abort(404);
        }
        $correctSlug = $article->translate()->slug;
        if ($correctSlug !== $slug) {
            return redirect()->route('article.show', $correctSlug);
        }

        $article->load([
            'categories',
            'comments' => function ($q) {
                $q->where('reviewed', 1);
            },
            'tags'
        ])->loadCount([
            'comments' => function ($q) {
                $q->where('reviewed', 1);
            }
        ]);
        $this->views_increase_article($article);
        $random_articles = Article::translatedIn()
            ->orderBy('id', 'DESC')->with(
                [
                    'categories' => function ($q) {
                        $q->first();
                    }
                ]
            )->paginate(5);
        return view('front.pages.article', compact('article', 'random_articles'));
    }

    public function page(Request $request, $slug)
    {
        $page = Page::whereHas('translations', fn($query) => $query->where('slug', $slug))->firstOrFail();
        if (!$page->translate()) {
            abort(404);
        }
        $correctSlug = $page->translate()->slug;
        if ($correctSlug !== $slug) {
            return redirect()->route('page.show', $correctSlug);
        }
        return view('front.pages.page', compact('page'));
    }

    public function blog(Request $request)
    {
        $articles = Article::translatedIn()->where(function ($q) use ($request) {
            if ($request->category_id != null) {
                $q->where('category_id', $request->category_id);
            }
            if ($request->user_id != null) {
                $q->where('user_id', $request->user_id);
            }
            if ($request->q) {
                $q->whereTranslationLike('title', '%' . $request->q . '%')->orWhereTranslationLike(
                    'description',
                    '%' . $request->q . '%'
                );
            }
        })->where('is_published', 1)->with(['categories', 'tags'])->withCount([
            'comments' => function ($q) {
                $q->where('reviewed', 1);
            }
        ])->orderBy('id', 'DESC')->paginate();
        return view('front.pages.blog', compact('articles'));
    }

    public function showTests()
    {
        $test = Test::first();
        return view('front.pages.tests', compact('test'));
    }

    public function prepareResult($slug)
    {
        if (!session('score')) {
            return redirect()->route('tests');
        }
        return view('front.pages.prepare-result', compact('slug'));
    }

    function generateCertificate($name, $score, $percent)
    {
        if ($this->isArabicOrEnglish($name) === 'ar' || ($name === '' && app()->getLocale() === 'ar'))
        {
            $textWidth = intval(mb_strlen($name));

            $Arabic = new Arabic('Glyphs');

            $name = $Arabic->utf8Glyphs($name);

            $template = Image::make(public_path('images/certificate-template_ar.png'));

            $x = $template->width() - $textWidth - 50;

            $template->text($name, $x, 170, function ($font) {
                $font->file(public_path('fonts/kufi-fixed/NotoKufiArabic-Bold.ttf'));
                $font->size(35);
                $font->color('#033467');
                $font->align('right');
                $font->valign('bottom');
            });
            // Add the name and score to the certificate
            $template->text($score, 850, 450, function ($font) {
                $font->file(public_path('fonts/Cairo-Regular.ttf'));
                $font->size(200);
                $font->color('#555555');
                $font->align('center');
                $font->valign('bottom');
            });

            $template->text($percent, 1075, 742, function ($font) {
                $font->file(public_path('fonts/Cairo-Regular.ttf'));
                $font->size(50);
                $font->color('#545490');
                $font->align('center');
                $font->valign('bottom');

            });
            $filename = session()->getId() . '.png';
            $template->save(public_path('certificates/' . $filename));

            return $filename;

        }
        else{
            $template = Image::make(public_path('images/certificate-template_en.png'));

            $template->text($name, 60, 160, function ($font) {
                $font->file(public_path('fonts/Cairo-Regular.ttf'));
                $font->size(45);
                $font->color('#033467');
                $font->align('left');
                $font->valign('bottom');
            });
            // Add the name and score to the certificate
            $template->text($score, 300, 450, function ($font) {
                $font->file(public_path('fonts/Cairo-Regular.ttf'));
                $font->size(200);
                $font->color('#555555');
                $font->align('center');
                $font->valign('bottom');
            });

            $template->text($percent, 200, 750, function ($font) {
                $font->file(public_path('fonts/Cairo-Regular.ttf'));
                $font->size(50);
                $font->color('#545490');
                $font->align('center');
                $font->valign('bottom');
            });
            $filename = session()->getId() . '.png';
            $template->save(public_path('certificates/' . $filename));

            return $filename;
        }

    }

    public function showResult($slug)
    {
        $score = session('score');
        $percentile = 0;
        $name = session('name');
        if ($score < 70 || $score > 130) {
            $percentile = 2.2;
        } elseif (in_array($score, range(70, 79)) || in_array($score, range(120, 130))) {
            $percentile = 6.7;
        } elseif (in_array($score, range(80, 89)) || in_array($score, range(110, 119))) {
            $percentile = 16.1;
        } elseif (in_array($score, range(90, 109))) {
            $percentile = 50;
        }

        $certificate = $this->generateCertificate($name, $score, $percentile);
        $test = Test::whereTranslation('slug', $slug)->firstOrFail();
        if (!session('score')) {
            return redirect()->route('tests');
        }
        $category = Category::whereTranslation('slug', 'improve-your-iq')->first();
        $articles = $category?->articles()->take(6)->get() ?? [];
        return view('front.pages.result', compact('articles', 'test', 'certificate'));
    }

    public function exam_instructions($slug)
    {
        return view('front.pages.instructions');
    }

    public function views_increase_article(Article $article)
    {
        $counter = $article->item_seens()->where('type', "ARTICLE")->where(
            'ip',
            \UserSystemInfoHelper::get_ip()
        )->whereDate('created_at', \Carbon::today())->count();
        if (!$counter) {
            \App\Models\ItemSeen::create([
                'type_id' => $article->id,
                'type' => "ARTICLE",
                'ip' => \UserSystemInfoHelper::get_ip(),
                'prev_link' => \UserSystemInfoHelper::prev_url(),
                'agent_name' => request()->header('User-Agent'),
                'browser' => \UserSystemInfoHelper::get_browsers(),
                'device' => \UserSystemInfoHelper::get_device(),
                'operating_system' => \UserSystemInfoHelper::get_os()
            ]);
            $article->update(['views' => $article->views + 1]);
        }
    }

    function isArabicOrEnglish($text)
    {
        // Match Arabic characters (Unicode range: 0600–06FF)
        $arabicRegex = '/[\x{0600}-\x{06FF}]/u';

        // Match English characters (Unicode range: 0000–007F)
        $englishRegex = '/[\x{0000}-\x{007F}]/u';

        // Check if the text contains Arabic characters
        if (preg_match($arabicRegex, $text)) {
            return 'ar';
        }

        // Check if the text contains English characters
        if (preg_match($englishRegex, $text)) {
            return 'en';
        }

        // The text contains neither Arabic nor English characters
        return 'Unknown';
    }

    public function testInstruction()
    {
        return view('front.pages.instructions');
    }
}

