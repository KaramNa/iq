@extends('layouts.app', ['page_title'=>$tests[0]->translate()->title,'seo_meta_description'=>$tests[0]->translate()->meta_description,'page_image'=>$tests[0]->image()])

@section('content')

    <div class="container py-10 " style="min-height:70vh">

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row shadow-lg p-5">

                    <div class="col-lg-6">
                        <h1>@lang('admin.online_iq_free_tes')</h1>
                        <p>
                            @lang('admin.iq_test_brief')
                        </p>
                        <p>
                            @lang('admin.ads_may_show')
                        </p>

                        <h4>@lang('admin.preview')</h4>
                        <p>
                            <img class="img-fluid"
                                 alt="Online IQ Test (Free Version)"
                                 title="What should come next to complete the sequence/pattern of shapes?"
                                 src="{{ $tests[0]->image('original') }}">
                        </p>
                    </div>

                    <div class="col-lg-6">
                        <h3>@lang('Details of the test:')</h3>
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
                        </ul>

                        @if ($tests[0]->questions->count() > 0)
                            <form method="GET" action="{{ route('take.test', $tests[0]->translate()->slug) }}">
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
