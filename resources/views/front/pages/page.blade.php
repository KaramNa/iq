@extends('layouts.app',['page_title'=>$page->title,'seo_meta_description'=>$page->meta_description])
@section('content')
    <div class="col-12 bg-light pt-6 px-0">


        <section class="section-frame overflow-hidden">
            <div class="wrapper bg-soft-primary">
                <div class="container py-12 py-md-10 text-center">
                    <div class="row">
                        <div class="col-md-7 col-lg-6 col-xl-5 mx-auto">
                            <h1 class="display-1 mb-3 text-center">{{ucwords($page->translate()->title)}}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="col-12 p-0 bg-light">
            <div class=" p-0 container">
                <div class="col-12 p-2 p-lg-5 row front-content" style="min-height:70vh">
                    {!!$page->description!!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#share-bar').share();
    </script>
@endsection
