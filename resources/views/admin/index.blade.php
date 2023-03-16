@extends('layouts.admin' ,['page_title' => __('admin.dashboard')])
@section('content')
    <div class="col-12 p-3 row">
        @can('users-read')
            <x-dashboard.info-box text="admin.users" count="{{\App\Models\User::count()}}" route="admin.users.index"/>
        @endcan

        <x-dashboard.info-box text="admin.notifications" count="{{auth()->user()->unreadNotifications->count()}}"
                              route="admin.notifications.index"/>

        @can('articles-read')
            <x-dashboard.info-box text="admin.articles" count="{{\App\Models\Article::count()}}"
                                  route="admin.articles.index"/>
        @endcan

        @can('categories-read')
            <x-dashboard.info-box text="admin.categories" count="{{\App\Models\Category::count()}}"
                                  route="admin.categories.index"/>
        @endcan

        @can('hub-files-read')
            <x-dashboard.info-box text="admin.file_manager" count="{{\App\Models\HubFile::count()}}"
                                  route="admin.files.index"/>
        @endcan

        @can('menus-read')
            <x-dashboard.info-box text="admin.menus" count="{{\App\Models\Menu::count()}}" route="admin.menus.index"/>
        @endcan

        @can('pages-read')
            <x-dashboard.info-box text="admin.pages" count="{{\App\Models\Page::count()}}" route="admin.pages.index"/>
        @endcan

        @can('contacts-read')
            <x-dashboard.info-box text="admin.contact" count="{{\App\Models\Contact::count()}}"
                                  route="admin.contacts.index"/>
        @endcan

        @can('announcements-read')
            <x-dashboard.info-box text="admin.announcements" count="{{\App\Models\Announcement::count()}}"
                                  route="admin.announcements.index"/>

        @endcan

        <div class="col-12 px-2 py-2">
            <div
                style="height: 4px ;background: rgb(118 169 169);border-radius: 7px;transition: width .5s ease-in-out;width: 0%;"
                id="home-dashboard-divider"></div>
        </div>

        <livewire:dashboard-statistics/>
    </div>
@endsection
