@extends('layouts.app', ['seo_meta_description'=> __('home.seo_meta_description')])
@section('content')
    <x-start/>
{{--    <x-numbers/>--}}
    <x-faqs/>
    <x-blog/>
    <x-about/>
{{--    <x-call-to-action/>--}}
@endsection
