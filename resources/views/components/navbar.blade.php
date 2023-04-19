<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<div class="col-12 fixed-top  main-nav shadow" style="background: #fff;padding: 3px 0px;min-height: 65px;">
    <div class="container px-1 my-auto">
        <div class="col-12 row p-0">
            <div class="col-auto p-3 d-flex align-items-center hover-main-color-flexable"
                 onclick="document.getElementById('aside-menu').classList.toggle('active');document.getElementById('body-overlay').classList.toggle('active');"
                 style="cursor: pointer;">
                <span class="far fa-bars font-3 px-0"></span>
            </div>
            <div class="col-auto d-flex align-items-center px-1 py-2">
                <a href="/">
                    <img src="{{$settings['get_website_logo']}}" style="width: 220px;"
                         alt="{{$settings['website_name']}}">
                </a>
            </div>
            <div class="col me-auto p-0 row justify-content-between d-flex">
                <div class="col row m-0 px-2">

                    @php
                        $menu = \App\Models\Menu::where('location',"NAVBAR")->with(['links'=>function($q){$q->orderBy('order','ASC');}])->first();
                    @endphp
                    @if($menu !=null)
                        @foreach($menu->links as $link)
                            <div class="col-auto  d-none d-lg-flex align-items-center p-0 mx-1 ">
                                <a href="{{$link->url}}"
                                   class="d-flex align-items-center py-2 px-3 top-navbar-link rounded"
                                   style="color: inherit;">
                                    <span
                                        class="{{$link->icon}} mx-1"></span> {{$link->translate()->title }}
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>

                <x-language-switch/>

            </div>
        </div>
    </div>
</div>
<div id="aside-menu" class=" shadow">
    <div class="col-12 d-flex justify-content-between  align-items-center p-0 shadow">
        <span class="px-3 font-1 kufi">

            <img src="{{$settings['get_website_logo']}}" style="width: 220px;" alt="{{$settings['website_name']}}">

        </span>
        <span class="d-flex">
            <span class="font-1"><span class="far fa-times font-3 px-4 py-3" style="cursor: pointer;"
                                       onclick="document.getElementById('aside-menu').classList.toggle('active');document.getElementById('body-overlay').classList.toggle('active');">

                </span>
            </span>
        </span>
    </div>
    <div class="col-12 p-0">
        <div class="col-12 p-0 aside-scroll pt-2"
             style="height: calc(100vh - 186px);overflow: auto;position: relative;">

            @if($menu !=null)
                @foreach($menu->links as $link)
                    <div class="nav-item ">
                        <a href="{{$link->url}}" style="color: inherit;" class="d-block">
                            <div class="nav-link" style="cursor: pointer;">
                                <div class="col-12 px-0 row">
                                    <div class="col-12 px-0 kufi">
                                        <span
                                            class="{{$link->icon}} mx-1"></span> {{$link->translate()->title }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif


        </div>
        <div class="col-12 px-0 py-2" style="position:absolute;width: 100%;">
            <div class="col-12  p-0">
                <div class="col-12 p-0">
                    <ul style=";padding: 0px;list-style: none;min-height: 48px;"
                        class="d-flex align-items-center justify-content-center row my-2">
                        @if($settings['facebook_link']!=null)
                            <a href="{{$settings['facebook_link']}}" class="d-inline-block p-1" style="width:48px">
                                <span class="fab fa-facebook-f d-inline-block border rounded-circle"
                                      style="width: 40px;@height: 40px;padding: 11px 14px ;color: #3b5998;cursor: pointer;"></span>
                            </a>
                        @endif
                        @if($settings['twitter_link']!=null)
                            <a href="{{$settings['twitter_link']}}" class="d-inline-block p-1" style="width:48px">
                                <span class="fab fa-twitter d-inline-block border rounded-circle"
                                      style="width: 40px;height: 40px;padding: 11px 11px ;color: #00aced;cursor: pointer;"></span>
                            </a>
                        @endif
                        @if($settings['youtube_link']!=null)
                            <a href="{{$settings['youtube_link']}}" class="d-inline-block p-1" style="width:48px">
                                <span class="fab fa-youtube d-inline-block border rounded-circle"
                                      style="width: 40px;height: 40px;padding: 11px 10px ;color: #FF0000;cursor: pointer;"></span>
                            </a>
                        @endif
                        @if($settings['linkedin_link']!=null)
                            <a href="{{$settings['linkedin_link']}}" class="d-inline-block p-1" style="width:48px">
                                <span class="fab fa-linkedin-in d-inline-block border rounded-circle"
                                      style="width: 40px;height: 40px;padding: 11px 12px ;color: #1976d2;cursor: pointer;"></span>
                            </a>
                        @endif
                        @if($settings['telegram_link']!=null)
                            <a href="{{$settings['telegram_link']}}" class="d-inline-block p-1" style="width:48px">
                                <span class="fab fa-telegram-plane d-inline-block border rounded-circle"
                                      style="width: 40px;height: 40px;padding: 11px 12px ;color: #1e96c8;cursor: pointer;"></span>
                            </a>
                        @endif
                    </ul>
                </div>
                <div class="col-12 p-0 text-center" style="font-size: 12px;color: var(--font-1);">
                    @lang('footer.all_rights_reserved') © {{$settings['website_name']}} {{date('Y')}}
                </div>
            </div>
        </div>
    </div>
</div>
