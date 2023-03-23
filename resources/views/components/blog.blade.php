<section class="wrapper bg-light">
    <style>
        .article-img:hover{
            filter: brightness(35%);
        }
    </style>
    <div class="overflow-hidden">
        <div class="container py-14 py-md-16">
            <div class="row">
                <div class="col-xl-7 col-xxl-6 mx-auto text-center">
                    <h2 class="display-4 text-center mt-2 mb-10">@lang('blog.latest_posts')</h2>
                </div>
            </div>

            <div class="col-12 row p-0">

                @foreach(App\Models\Article::translatedIn()->where('is_published', 1)->latest()->take(6)->get() as $article)
                    <div class="col-12 col-lg-4 mb-4">
                        <article>
                            <div class="card shadow-lg">
                                <figure class="card-img-top overlay overlay-1"><a
                                        href="{{route('article.show',$article->translateOrDefault()->slug)}}"> <img
                                            src="{{ $article->image() }}"
                                            alt="{{ $article->translateOrDefault()->title }}" class="article-img"/></a>
                                    <figcaption>
                                        <h5 class="from-top mb-0 text-center display-3">@lang('See more')</h5>
                                    </figcaption>
                                </figure>
                                <div class="card-body p-6">
                                    <div class="post-header">
                                        <div class="post-category">
                                            @foreach($article->categories as $article_category)
                                                @if($loop->index<3)
                                                    <a href="{{route('category.show',$article_category)}}"
                                                       class="hover" rel="category">{{$article_category->name}}</a>
                                                @endif
                                            @endforeach
                                        </div>
                                        <h2 class="post-title h3 mt-1 mb-3">
                                            <a class="link-dark"
                                               href="{{route('article.show',$article->translate(app()->getLocale())->slug)}}">
                                                {{$article->title}}
                                            </a>
                                        </h2>
                                    </div>
                                    <div class="post-footer">
                                        <ul class="post-meta d-flex mb-0">
                                            <li class="post-date">
                                                <span>
                                                    <i class="fal fa-clock"></i>
                                                    {{\Carbon::parse($article->created_at)->diffForHumans()}}
                                                </span>
                                            </li>
                                            @if($article->comments_count==null || $article->comments_count ==0)
                                                <li class="post-comments">
                                                    <a href="#">  {{$article->comments_count}}
                                                        <i class="fal fa-comment"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
