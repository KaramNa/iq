{{--['page_title'=>$page->title,'seo_meta_description'=>$page->meta_description]--}}
@extends('layouts.app')

@section('content')
    <style>
        .wrapper{
            height: 300px;
        }

        h1 {
            font-size: 50px;
            font-family: 'Poppins', sans-serif;
            margin-bottom: 0;
            line-height: 1;
            font-weight: 700;
        }

        p{
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <div class="col-12 bg-light pt-6 px-0 d-flex align-items-center justify-content-center flex-column   wrapper">
        <h1 class="text-center py-5">Coming Soon, Stay tuned!</h1>
        <p>We're working on a great set of IQ tests </p>
    </div>
@endsection
