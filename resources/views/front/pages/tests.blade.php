@extends('layouts.app', ['page_title'=>$test->translate()->title,'seo_meta_description'=>$test->translate()->meta_description,'page_image'=>$test->image('original')])

@section('content')
    <style>
        h2{
            color: #228b22;
        }
    </style>
    <div class="container py-10 " style="min-height:70vh">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row shadow-lg p-5">
                    <h1 class="text-center mb-5">@lang('admin.online_iq_free_test')</h1>
                    <div class="col-lg-6">
                        <h2>@lang('admin.test_instructions'):</h2>
                        <ul class="p-0">
                            <li>{{ trans('Look at the given figures and try to identify a pattern or rule that governs their shape.') }}</li>
                            <li>{{ trans('The figure may be symmetrical along one or more axes.') }}</li>
                            <li>{{ trans('The figure may include elements that rotate or turn in a specific direction.') }}</li>
                            <li>{{ trans('The size or orientation of the figures may change in a particular way.') }}</li>
                            <li>{{ trans('Apply the pattern or rule you identified earlier to determine what the missing shape should be.') }}</li>
                        </ul>

                        <p>{{ trans('By following these instructions and looking for patterns in the figures, you should be able to approach the questions with greater confidence and understanding.') }}</p>

                        <h4>@lang('admin.preview')</h4>
                        <p>
                            <img class="img-fluid"
                                 alt="Online IQ Test (Free Version)"
                                 title="What should come next to complete the sequence/pattern of shapes?"
                                 src="{{ $test->image('original') }}">
                        </p>
                    </div>

                    <div class="col-lg-6">
                        <h2>@lang('Details of the test:')</h2>
                        <ul class="list-group mb-5" style="list-style: none;padding: 5px;">
                            <x-li-checkmark :text="trans('20 multiple-choice questions.')"/>
                            <x-li-checkmark :text="trans('25 minutes to complete the test.')"/>
                            <x-li-checkmark
                                :text="trans('Assesses a range of cognitive abilities, including verbal reasoning, spatial perception, and logical thinking')"/>
                            <x-li-checkmark
                                :text="trans('Completely free of charge and does not require any registration or personal information')"/>
                            <x-li-checkmark
                                :text="trans('Test-takers can take the test at their own pace and from the comfort of their own device.')"/>
                            <x-li-checkmark
                                :text="trans('The test results are provided immediately after completion and are also free of charge.')"/>
                            <x-li-checkmark
                                :text="trans('admin.ads_may_show')"/>
                        </ul>

                        @if ($test->questions->count() > 0)
                            <form method="GET" action="{{ route('take.test', $test->translate()->slug) }}">
                                @csrf
                                <div class="mb-3">
                                    <div>
                                        <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                               for="test_taker_name"
                                        >
                                            @lang('admin.name')
                                        </label>
                                    </div>

                                    <input class="border border-gray-400 p-2 form-control"
                                           type="text"
                                           name="test_taker_name"
                                           id="test_taker_name"
                                           value="{{ old('test_taker_name') }}"
                                           placeholder="{{ trans('Enter your name') }}"
                                           required
                                    >
                                </div>
                                <div class="mb-3">
                                    <div>
                                        <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
                                               for="test_taker_age"
                                        >
                                            @lang('admin.age')
                                        </label>
                                    </div>

                                    <input class="border border-gray-400 p-2 form-control"
                                           type="number"
                                           name="test_taker_age"
                                           id="test_taker_age"
                                           value="{{ old('test_taker_age') }}"
                                           placeholder="{{ trans('Enter your age') }}"
                                           min="0"
                                           required
                                    >

                                    @error("test_taker_age")
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                @error("test_taker_name")
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror

                                <button class="btn btn-primary btn-lg w100">
                                    @lang('Start the free online test →')
                                </button>
                            </form>

                        @else
                            <p class="bg-primary p-4 rounded text-white col-sm-12">
                                @lang('No Questions available yet')
                            </p>
                        @endif
                    </div>
                </div>
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
