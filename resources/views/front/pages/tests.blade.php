@extends('layouts.app', ['page_title'=>$tests[0]->testCategory->translate()->name,'seo_meta_description'=>$tests[0]->testCategory->translate()->meta_description,'page_image'=>$settings['website_cover']])

@section('content')

    <div class="container py-10 " style="min-height:70vh">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row p-5">
                    <h1 class="text-center mb-10">@lang('admin.iq_free_tests')</h1>
                    @foreach($tests as $test)
                        <div class="col-lg-4 mb-5">
                            <div class="card">
                                <a href="{{ route('test.instruction', $test->translate()->slug) }}">
                                    <img src="/images/{{$test->level}}.jpg" class="card-img-top" alt="...">
                                </a>
                                <div class="card-body p-5">
                                    <h5 class="card-title">
                                        <a href="{{ route('test.instruction', $test->translate()->slug) }}">
                                            <p class="h3 text-primary">
                                            @if ($test->level === 0)
                                                {{ trans('Easy Level') }}
                                            @elseif($test->level === 1)
                                                {{ trans('Medium Level') }}
                                            @elseif($test->level === 2)
                                                {{ trans('Hard Level') }}
                                            @endif
                                            </p>
                                        </a>
                                    </h5>
                                    <p class="card-text">{!! $test->translate()->description !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

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
