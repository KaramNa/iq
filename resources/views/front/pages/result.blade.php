@extends('layouts.app', ['page_title'=>$test->title,'seo_meta_description'=>$test->meta_description,'page_image'=> '/certificates/' . $certificate])

@section('meta')
    <meta name="robots" content="noindex, nofollow"/>
@stop
@section('content')

    <style>
        .article-img:hover {
            filter: brightness(35%);
        }

        .social-media {
            display: flex;
            justify-content: center;
        }

        .btn-share {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            margin: 0 10px;
            border-radius: 50%;
            color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .btn-share:hover {
            transform: scale(1.2);
            color: #fff;
        }

        .facebook {
            background-color: #3b5999;
        }

        .twitter {
            background-color: #1da1f2;
        }

        .linkedin {
            background-color: #0077b5;
        }

        .fa {
            font-size: 22px;
        }

    </style>

    <div class="container py-10 " style="min-height:70vh">
        <div class="col-md-10 mx-auto">
            <div class="text-center">
                <img class="img-fluid mb-5" src="{{ '/certificates/' . $certificate }}" alt="">
                <div>
                    <p class="h3 text-center">{{ trans('Be proud of yourself and share your result with your friends') }}</p>
                    <div class="social-media text-center">

                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('test.result', $test->translate('en')->slug) }}&quote={{ urlencode('Get your IQ score with iqfreetest.org for free') }}"
                           class="btn-share facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?url={{ route('test.result', $test->translate('en')->slug) }}&text={{ urlencode('Get your IQ score with iqfreetest.org for free') }}"
                           class="btn-share twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ route('test.result', $test->translate('en')->slug) }}&title={{ urlencode('Check out my IQ score of ' . session('score')) }}&summary={{ urlencode('Get your IQ score with iqfreetest.org for free') }}&source=LinkedIn"
                           class="btn-share linkedin" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="shadow-lg p-4 mt-5">

                @if (session('score') < 70)

                    <p>{{ trans('admin.overview.less_than_70') }}</p>
                    <p>{{ trans('admin.overview.note') }}</p>
                    <p>{{ trans('admin.tips.dont_worry') }}</p>
                    <p>{{ trans('admin.tips.less_than_70') }}</p>

                @elseif(in_array(session('score'), range(70,79)))

                    <p>{{ trans('admin.overview.between_70_79') }}</p>
                    <p>{{ trans('admin.overview.note') }}</p>
                    <p>{{ trans('admin.tips.dont_worry') }}</p>
                    <p>{{ trans('admin.tips.between_70_79') }}</p>

                @elseif(in_array(session('score'), range(80,89)))

                    <p>{{ trans('admin.overview.between_80_89') }}</p>
                    <p>{{ trans('admin.overview.note') }}</p>
                    <p>{{ trans('admin.tips.dont_worry') }}</p>
                    <p>{{ trans('admin.tips.between_80_89') }}</p>

                @elseif(in_array(session('score'), range(90,109)))

                    <p>{{ trans('admin.overview.between_90_109') }}</p>
                    <p>{{ trans('admin.overview.note') }}</p>
                    <p>{{ trans('admin.tips.dont_worry') }}</p>
                    <p>{{ trans('admin.tips.between_90_109') }}</p>

                @elseif(in_array(session('score'), range(110,119)))

                    <p>{{ trans('admin.overview.between_110_119') }}</p>
                    <p>{{ trans('admin.overview.note') }}</p>
                    <p>{{ trans('admin.tips.between_110_119') }}</p>

                @elseif (in_array(session('score'), range(120,129)))

                    <p>{{ trans('admin.overview.between_120_129') }}</p>
                    <p>{{ trans('admin.overview.note') }}</p>
                    <p>{{ trans('admin.tips.between_120_129') }}</p>

                @elseif(session('score') > 130)

                    <p>{{ trans('admin.overview.above_130') }}</p>
                    <p>{{ trans('admin.overview.note') }}</p>
                    <p>{{ trans('admin.tips.above_130') }}</p>

                @endif


                <p class="mb-10 h3">{{ trans('admin.tips.resources') }}</p>
                <div class="col-12 row p-0">

                    @foreach($articles as $article)
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

    </div>

@endsection
