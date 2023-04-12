@props(['page_title' => trans('admin.dashboard')])
    <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/dashboard.css')
    <title>{{ $page_title }}</title>
    <link rel="icon" type="image/png" sizes="512x512"
          href="{{$settings['get_website_icon']}}"/>
    <style>
        html {
            --background-0: #eef4f5;
            --background-1: #fff;
            --background-aside: #11233b;
            --background-active-link: #141e2e;
            --background-form-control-focus: #161d26;
            --color-1: #fff;
            --color-2: #575f66;
            --border-color: #f1f1f1;
            --bs-table-hover-color: #f7f7f7 !important;
        }
    </style>
    @livewireStyles
    @yield('styles')
    @if(auth()->check())
        @php
            if(session('seen_notifications') == null){
                session(['seen_notifications' => 0]);
            }
            $notifications=auth()->user()->notifications()->orderBy('created_at','DESC')->limit(50)->get();
            $unreadNotifications=auth()->user()->unreadNotifications()->count();
        @endphp
    @endif
    @if($settings['dashboard_dark_mode'] == "1")
        <style>

            html {

                --background-0: #131923;
                --background-1: #1c222b;
                --background-aside: #11233b;
                --background-active-link: #141e2e;
                --background-form-control-focus: #161d26;

                --color-1: #fff;
                --color-2: #f1f1f1;
                --border-color: #282b2f;
                --bs-table-hover-color: #f7f7f7 !important;
            }

            .select2-dropdown, .select2-container--default .select2-selection--multiple, .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: var(--background-0) !important;
            }

            td, th {
                border-color: var(--border-color) !important;
            }

            .aside {
                background: #171f2a !important;
            }

            .aside * {
                color: var(--color-1) !important;
            }

            .aside .item-container.active {
                background: #192230 !important;
                box-shadow: 0px 12px 17px #101d30 !important;
                border-bottom: unset !important;
            }

            .aside .item-container.active * {
                color: #38b59c !important;
            }

            .sub-item.active a.active *, .sub-item.active a.active {
                color: #38b59c !important;
            }

            #home-dashboard-divider {
                background: #0194fe !important;
            }

            body {
                color: var(--color-1) !important;
                background: #131923 !important;
            }

            .main-box-wedit {
                box-shadow: unset;
                border-radius: 10px 25px 10px 25px;
                background: #1c222b !important;
            }

            .main-box {
                background: #1c222b !important;
                box-shadow: unset !important;
            }

            .btn {
                color: var(--color-2) !important;
            }

            table {
                color: var(--color-2) !important;
                border-color: var(--border-color) !important;
            }

            thead th {
                border-color: var(--border-color) !important;
            }

            .table-hover > tbody > tr:hover {

            }

            *, .dropdown-item {
                color: var(--color-1);
            }

            .dropdown-menu {
                background-color: var(--background-1) !important;
            }

            .dropdown-item:focus, .dropdown-item:hover {
                color: var(--color-1);
                background-color: var(--background-2) !important;
            }

            *[class*='border-'] {
                border-color: var(--border-color) !important;
            }

            hr {
                background: var(--border-color);
            }

            .form-control {
                background: rgb(39 38 37 / 20%);
                border-color: #8c6934;
            }

            .form-control {
                background: var(--background-1);
                border-color: var(--border-color);
            }

            .form-control:focus {
                box-shadow: unset !important;
                border: 1px solid #ff9800 !important;
                background: #0e0d0c !important;
            }

            /*.form-control:focus {
                box-shadow: unset!important;
                border: 1px solid var(--border-color)!important;
                background: var(--background-form-control-focus)!important;
            }*/
            .form-control, .form-control:focus {
                color: var(--color-1);
            }

            .settings-tab-opener.active, .settings-tab-opener {
                box-shadow: unset !important;
            }
        </style>
    @endif
</head>

<body style="background: #eef4f5" class="dash">
<style>
    #toast-container > div {
        opacity: 1;
    }

    .phpdebugbar * {
        direction: ltr !important
    }
</style>
@yield('after-body')

<form method="POST" action="{{route('logout')}}" id="logout-form" class="d-none">@csrf</form>
<div class="col-12 d-flex">
    <div style="width: 260px;background: #ddeaea;min-height: 100vh;position: fixed;z-index: 900" class="aside active">
        <div class="col-12 px-0 d-flex" style="height: 55px">
            <div class="col-12 p-1" style="color: var(--background-1)">
                <div class="d-none d-md-none justify-content-center align-items-center px-0 asideToggle"
                     style="width: 40px;height: 40px;">
                    <span class="fal fa-bars font-4 cursor-pointer"></span>
                </div>
            </div>
        </div>
        <div class="col-12 px-0 pb-4 text-center justify-content-center align-items-center ">
            <a href="{{route('admin.profile.edit')}}">

                <img src="{{auth()->user()->getUserAvatar()}}"
                     style="width: 80px;height: 80px;color: var(--background-1);border-radius: 50%"
                     class="d-inline-block">
            </a>
            <div class="col-12 px-0 mt-2 text-center" style="color: #232323;">
                @lang('lang.hello') {{auth()->user()->name}}
            </div>
        </div>
        <div class="col-12 px-0">

            <div class="col-12 px-3 aside-menu" style="height: calc(100vh - 260px);overflow: auto;">

                <x-aside-item :text="trans('admin.dashboard')" :route="route('admin.index')" icon="fal fa-home"/>

                @can('roles-read')
                    <x-aside-item :text="trans('admin.roles')" :route="route('admin.roles.index')" icon="fal fa-key"/>
                @endcan

                @can('users-read')
                    <x-aside-item :text="trans('admin.users')" :route="route('admin.users.index')" icon="fal fa-users"/>
                @endcan

                <x-item-container :text="trans('admin.content')" icon="fal fa-newspaper">

                    <x-list-item permission="categories-read" :text="trans('admin.categories')" icon="fal fa-tag"
                                 :route="route('admin.categories.index')"/>

                    <x-list-item permission="articles-read" :text="trans('admin.articles')" icon="fal fa-book"
                                 :route="route('admin.articles.index')"/>

                    @php
                        $article_comments = \App\Models\ArticleComment::where('reviewed',0)->count();
                    @endphp

                    <x-list-item permission="comments-read" :text="trans('admin.comments')" icon="fal fa-comments"
                                 :route="route('admin.article-comments.index')" :count-label="$article_comments"/>

                    <x-list-item permission="announcements-read" :text="trans('admin.announcements')"
                                 icon="fal fa-bullhorn"
                                 :route="route('admin.announcements.index')"/>

                    <x-list-item permission="pages-read" :text="trans('admin.pages')" icon="fal fa-file-invoice"
                                 :route="route('admin.pages.index')"/>

                    <x-list-item permission="menus-read" :text="trans('admin.menus')" icon="fal fa-list"
                                 :route="route('admin.menus.index')"/>

                    <x-list-item permission="faqs-read" :text="trans('admin.faqs')" icon="fal fa-question"
                                 :route="route('admin.faqs.index')"/>

                    <x-list-item permission="redirections-read" :text="trans('admin.redirect')" icon="fal fa-directions"
                                 :route="route('admin.redirections.index')"/>

                    <x-list-item permission="tags-read" :text="trans('admin.tags')" icon="fal fa-tags"
                                 :route="route('admin.tags.index')"/>

                </x-item-container>

                <x-item-container :text="trans('admin.tests')" icon="fal fa-brain">

                    <x-list-item permission="test-takers-read" :text="trans('admin.test_takers')"
                                 :route="route('admin.test-taker.index')" icon="fal fa-graduation-cap"/>

                    <x-list-item permission="test-categories-read" :text="trans('admin.categories')"
                                 :route="route('admin.test-categories.index')" icon="fal fa-tag"/>

                    <x-list-item permission="tests-read" :text="trans('admin.tests')"
                                 :route="route('admin.tests.index')" icon="fal fa-puzzle-piece"/>



                </x-item-container>

                @can('contacts-read')
                    @php
                        $contacts_count = \App\Models\Contact::where('status','PENDING')->count();
                    @endphp

                    <x-aside-item :text="trans('admin.contact')" :route="route('admin.contacts.index')"
                                  :count-label="$contacts_count" icon="fal fa-phone"/>

                @endcan

                @can('settings-update')
                    <x-aside-item :text="trans('admin.settings')" :route="route('admin.settings.index')"
                                  icon="fal fa-wrench"/>
                @endcan

                <x-aside-item :text="trans('lang.logout')" icon="fal fa-sign-out-alt" logout="true"/>

            </div>
        </div>

    </div>
    <div class="main-content in-active" style="overflow: hidden;">
        <div class="col-12 px-0 d-flex justify-content-between top-nav"
             style="height: 55px;background: var(--background-1);position: fixed;width: 100%;width: calc(100% - 260px);z-index: 99;border-bottom: 1px solid var(--border-color);">
            <div class="col-12 px-0 d-flex justify-content-center align-items-center btn  asideToggle"
                 style="width: 55px;height: 55px;">
                <span class="fal fa-bars font-4"></span>
            </div>
            <div class="col-12 px-0 d-flex justify-content-end  " style="height: 60px;">
                <x-language-switch/>
                <div class="btn-group" id="notificationDropdown">

                    <div class="col-12 px-0 d-flex justify-content-center align-items-center btn  "
                         style="width: 55px;height: 55px;" data-bs-toggle="dropdown" aria-expanded="false"
                         id="dropdown-notifications">
                        <span class="fal fa-bell font-3 d-inline-block"
                              style="color: var(--color-2);transform: rotate(15deg)"></span>
                        <span style="position: absolute;min-width: 25px;min-height: 25px;
                            @if($unreadNotifications!=0)
                            display: inline-block;
                            @else
                            display: none;
                            @endif
                            right: 0px;top: 0px;border-radius: 20px;background: #c00;color:#fff;font-size: 14px;"
                              class="text-center" id="dropdown-notifications-icon">
                            {{$unreadNotifications}}
                        </span>

                    </div>
                    <div class="dropdown-menu py-0 rounded-0 border-0 shadow "
                         style="cursor: auto!important;z-index: 20000;width: 350px;height: 450px;top: -3px!important;">
                        <div class="col-12 notifications-container" style="height:406px;overflow: auto;">
                            <x-notifications :notifications="$notifications"/>
                        </div>
                        <div class="col-12 d-flex border-top">
                            <a href="{{route('admin.notifications.index')}}" class="d-block py-2 px-3 ">
                                <div class="col-12 align-items-center">
                                    <span class="fal fa-bells"></span>
                                    @lang('admin.view_all_notifications')
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 px-0 d-flex justify-content-center align-items-center  dropdown"
                     style="width: 55px;height: 55px;">
                    <div style="width: 55px;height: 55px;cursor: pointer;" data-bs-toggle="dropdown"
                         aria-expanded="false" class="d-flex justify-content-center align-items-center cursor-pointer">
                        <img src="{{auth()->user()->getUserAvatar()}}"
                             style="padding: 10px;border-radius: 50%;width: 55px;height: 55px;">
                    </div>
                    <ul class="dropdown-menu shadow border-0" aria-labelledby="dropdownMenuButton1" style="top: -3px;">
                        <li><a class="dropdown-item font-1" href="/" target="_blank"><span
                                    class="fal fa-desktop font-1"></span> @lang('admin.view_site')</a></li>
                        <li><a class="dropdown-item font-1" href="{{route('admin.profile.index')}}"><span
                                    class="fal fa-user font-1"></span> @lang('admin.my_profile')</a></li>

                        <li><a class="dropdown-item font-1" href="{{route('admin.profile.edit')}}"><span
                                    class="fal fa-edit font-1"></span> @lang('admin.edit_my_profile')</a></li>


                        @can('hub-files-read')
                            <li><a class="dropdown-item font-1" href="{{route('admin.files.index')}}"><span
                                        class="fal fa-file font-1"></span> @lang('admin.file_manager')</a></li>
                        @endcan


                        @can('traffics-read')
                            <li><a class="dropdown-item font-1" href="{{route('admin.traffics.index')}}"><span
                                        class="fal fa-traffic-light font-1"></span> @lang('admin.traffic')</a></li>
                        @endcan

                        @can('error-reports-read')
                            <li><a class="dropdown-item font-1" href="{{route('admin.traffics.error-reports')}}"><span
                                        class="fal fa-bug font-1"></span> @lang('admin.errors_log')</a></li>
                        @endcan


                        <li>
                            <hr style="height: 1px;margin: 10px 0px 5px;">
                        </li>
                        <li><a class="dropdown-item font-1" href="#"
                               onclick="document.getElementById('logout-form').submit();"><span
                                    class="fal fa-sign-out-alt font-1"></span> @lang('lang.logout')</a></li>
                    </ul>

                </div>

                <div class="dropdown" style="width: 55px;height: 55px;background: #2381c6">
                    <span class="d-inline-block fal fa-user"></span>
                </div>

            </div>
        </div>
        <div class="col-12 px-0  " style="margin-top: 55px;position: relative;">
            <div
                style="position:fixed;display: flex;align-items: center;justify-content: center;height: 100vh;background: var(--background-1);z-index: 10;margin-top: -15px;"
                id="loading-image-container">
                <img src="/images/loading.gif" style="position:fixed;width: 120px;max-width: 80%;margin-top: -60px;"
                     id="loading-image">
            </div>

            @yield('content')
        </div>
    </div>
</div>

@vite('resources/js/dashboard.js')
@livewireScripts
@include('layouts.scripts')
@yield('scripts')
@stack('scripts')

</body>
</html>
