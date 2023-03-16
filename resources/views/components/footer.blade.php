<footer class=" pt-5" style="background:#fff;border-top:1px solid #f1f1f1;">

    <div class="container pb-12 text-center pt-12">
        <div class="row mt-n10 mt-lg-0">
            <div class="col-xl-12 mx-auto">
                <div class="row mb-3 d-flex">
                    {{--                    <div class="col-md-6 mb-3">--}}
                    {{--                        <div class="widget">--}}
                    {{--                            <img src="{{$settings['get_website_wide_logo']}}" style="width:160px;max-width:100%"--}}
                    {{--                                 class="mb-3">--}}
                    {{--                            <div style="text-align:justify;">{{$settings['website_bio']}}</div>--}}
                    {{--                        </div>--}}
                    {{--                        <!-- /.widget -->--}}
                    {{--                    </div>--}}

                    {{--                    <div class="col-lg-2 mb-3">--}}
                    {{--                        <div class="widget">--}}
                    {{--                            <div class="widget-title display-6 mb-5">@lang('footer.tests')</div>--}}

                    {{--                            @php--}}
                    {{--                                $menu = \App\Models\Menu::where('location',"NAVBAR")->with(['links'=>function($q){$q->orderBy('order','ASC');}])->first();--}}
                    {{--                            @endphp--}}
                    {{--                            @if($menu !=null)--}}
                    {{--                                @foreach($menu->links as $link)--}}
                    {{--                                    <div>--}}
                    {{--                                        <a href="{{$link->url}}" class="link-body">--}}
                    {{--                                            <span--}}
                    {{--                                                class="{{$link->icon}} font-1 d-none"--}}
                    {{--                                                style="color: #0194fe;width: 15px">--}}
                    {{--                                            </span>--}}
                    {{--                                            {{$link->{'title_' . app()->getLocale()} }}--}}
                    {{--                                        </a>--}}
                    {{--                                    </div>--}}
                    {{--                                @endforeach--}}
                    {{--                            @endif--}}

                    {{--                        </div>--}}
                    {{--                        <!-- /.widget -->--}}
                    {{--                    </div>--}}
                    <div class="col-lg-5 mb-3">
                        <div class="widget">
                            <div class="widget-title display-6 mb-5">@lang('footer.articles')</div>

                            @php
                                $articles = App\Models\Article::translatedIn()->where('is_published', 1)->latest()->take(6)->get()
                            @endphp
                            @if($articles->count() != 0 )
                                @foreach($articles as $article)
                                    <div>
                                        <a
                                            href="{{route('article.show',$article->translateOrDefault()->slug)}}"
                                            class="link-body">
                                            {{ $article->translateOrDefault()->title }}
                                        </a>
                                    </div>
                                @endforeach
                            @endif


                        </div>
                        <!-- /.widget -->
                    </div>
                    <div class="col-lg-2 mb-3">
                        <div class="widget">
                            <div class="widget-title display-6 mb-5">@lang('footer.site_links')</div>

                            @php
                                $menu = \App\Models\Menu::where('location',"NAVBAR")->with(['links'=>function($q){$q->orderBy('order','ASC');}])->first();
                            @endphp
                            @if($menu !=null)
                                @foreach($menu->links as $link)
                                    <div><a href="{{$link->url}}" class="link-body"><span
                                                class="{{$link->icon}} font-1 d-none"
                                                style="color: #0194fe;width: 15px"></span> {{$link->translate()->title }}
                                        </a></div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @php
                        $social_links = \App\Models\Setting::where('category', 'social')->where('value', '<>', '')->get(['value', 'icon']);
                    @endphp
                    @if(!$social_links->isEmpty())
                        <div class="col-lg-3 mb-3">
                            <div class="widget">
                                <div class="widget-title display-6 mb-5">@lang('footer.social_media')</div>

                                <nav class="nav social">
                                    @foreach($social_links as $social_link)
                                        @if ($social_link)
                                            <a href="{{$social_link->value}}"><i
                                                    class="{{ $social_link->icon }}"></i></a>
                                        @endif
                                    @endforeach
                                </nav>

                            </div>
                            <!-- /.widget -->
                        </div>
                    @endif

                    <!--/column -->
                </div>
                <!--/.row -->

                <!-- /.social -->
            </div>
            <!-- /column -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</footer>

<div class="col-12"
     style="background-image: linear-gradient(to right, rgba(0,0,0,0.01) , rgba(0,0,0,0.01) );border-top:1px solid rgb(145 145 145 / 3%);display: flex; align-items: center;justify-content: center;direction: rtl;">
    <div class="container ">
        <div class="col-12 row d-flex justify-content-between p-0">
            <div class="col-12 text-center mt-1 mb-2 pt-3 pb-2 ">
                <p style="font-size: 14px;line-height: 1.8;margin:0px"
                   class="my-0  kufi text-center">
                    <span
                        class="d-inline-block kufi"> @lang('footer.all_rights_reserved') © {{$settings['website_name']}} {{date('Y')}}</span>
                </p>
            </div>
        </div>
    </div>
</div>
