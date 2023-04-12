@extends('layouts.app', ['seo_meta_description'=> __('home.seo_meta_description')])
@section('content')

    <style>
        .ads {
            width: 100%;
            height: auto;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
    </style>

    <x-start/>
    {{--    <x-numbers/>--}}
    <x-faqs/>
    <div class='ads'>
        <script async
                src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8850148730668018"
                crossorigin="anonymous"></script>
    </div>

    <x-blog/>
    <x-about/>
    {{--    <x-call-to-action/>--}}
@endsection
@section('scripts')
    <script>
        $('#share-bar').share();
    </script>
@endsection
