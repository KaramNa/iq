<!doctype html>
<html lang="{{ Config::get('app.locale') }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    @include('seo.index')

    {!!$settings['header_code']!!}
    @livewireStyles
    @if(auth()->check())
        @php
            if(session('seen_notifications')==null)
                session(['seen_notifications'=>0]);
            $notifications=auth()->user()->notifications()->orderBy('created_at','DESC')->limit(50)->get();
            $unreadNotifications=auth()->user()->unreadNotifications()->count();
        @endphp
    @endif
    @vite('resources/css/app.css')
    <style>
        body {
            --bg-main: #fff;
            --bg-second: #f4f4f4;
            --font-1: #333333;
            --font-2: #555555;
            --border-color: #dddddd;
            --main-color: #0194fe;
            --main-color-rgb: 1, 148, 254;
            --main-color-flexable: #0194fe;
            --scroll-bar-color: #d1d1d1;
        }

        body.night {
            --bg-main: #1c222b;
            --bg-second: #131923;
            --font-1: #fff;
            --font-2: #e3e3e3;
            --border-color: #33343b;
            --main-color: #0194fe;
            --main-color-rgb: 1, 148, 254;
            --main-color-flexable: #15202b;
            --scroll-bar-color: #505050;
        }

        .dropdown-menu {
            min-width: 5rem;
        }

        body, * {
            direction: {{ Config::get('app.locale') == 'ar' ? 'rtl' : 'ltr' }};
        }

        .fa-pinterest-p:before {
            content: "\f231";
        }

        .fa-tumblr:before {
            content: "\f173";
        }

        .fa-reddit-alien:before {
            content: "\f281";
        }
        .fa-download:before {
            content: "\f019";
        }
    </style>
    @yield('styles')
</head>
<body style="background:#eef4f5;margin-top: 65px;" class="body">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K3ZJG84"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<style>
    #toast-container > div {
        opacity: 1;
    }
</style>
@yield('after-body')
<div id="app">
    <div id="body-overlay"
         onclick="document.getElementById('aside-menu').classList.toggle('active');document.getElementById('body-overlay').classList.toggle('active');"></div>
    <x-navbar/>
    <main class="p-0 font-2">
        @yield('content')
    </main>
    <x-share-bar/>

    <x-footer/>
</div>

@vite('resources/js/app.js')
@livewireScripts
{{--@include('layouts.scripts')--}}


{!!$settings['footer_code']!!}
<script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"
        integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
<script src={{ asset("js/jquery-social-share-bar1.js") }}></script>

@yield('scripts')
</body>
</html>
