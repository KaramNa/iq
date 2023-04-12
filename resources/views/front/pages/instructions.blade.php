{{--['page_title'=>$page->title,'seo_meta_description'=>$page->meta_description]--}}
@extends('layouts.app')

@section('content')

    <div class="col-12 p-0 mb-15">
        <div class=" p-0 container py-10 " style="min-height:70vh">


            <div class="row justify-content-center">
                <div class="col-md-10 order-1 order-md-2">
                    <div class="row m-b-10">

                        <div class="col-md-12">
                            <h2>Online IQ Test (Free Version)</h2>
                        </div>

                        <div class="col-md-6 p-body">

                            <p class="m-t-0">
                                The free version is a complete intelligence test with 30 questions to challenge your
                                intellectual ability. You’ll have your cognitive ability tested like never before, and
                                the number of correct answers will be shown at the end.
                            </p>
                            <p>
                                Ads may be displayed to allow us to provide your scores for free!
                            </p>

                            <h4>Preview</h4>
                            <p class="m-b-0">
                                <img width="600" height="300" class="img-fluid img-responsive img-preview"
                                     alt="Online IQ Test (Free Version)" title="Which figure is the odd one out?"
                                     src="/images/worldwideiqtest/iq-tests/online-iq-test-free/v1/online-iq-test-free.png">
                            </p>
                            <h5 class="m-t-0 m-b-30">Which figure is the odd one out?</h5>
                        </div>

                        <div class="col-md-6">
                            <ul class="pricing-offers">
                                <li><b>Details of the test:</b></li>
                                <li class="m-l-15"><i class="fas fa-fw fa-blue fa-check-circle"></i> 30 Questions</li>
                                <li class="m-l-15"><i class="fas fa-fw fa-blue fa-check-circle"></i> Culture Fair</li>
                                <li class="m-l-15"><i class="fas fa-fw fa-blue fa-check-circle"></i> No Time Limit</li>
                                <li class="m-l-15"><i class="fas fa-fw fa-blue fa-check-circle"></i> Instant Results
                                    (the correct answers and logical explanations for each question and your choices
                                    will be displayed).<br><br><b>Please note</b>: Since this test is not yet
                                    calibrated, unfortunately, we cannot display the exact IQ score. However, this is an
                                    excellent quiz for practicing and training.
                                </li>
                                <li class="m-l-15"><i class="fas fa-fw fa-blue fa-check-circle"></i> Free Of Charge</li>
                                <li class="m-l-15"><i class="fas fa-fw fa-blue fa-check-circle"></i> May Contain Ads
                                </li>
                            </ul>


                            <a href="{{ route('take.test', request()->slug) }}"
                               class="btn btn-primary btn-lg w100">
                                Start the free online test →
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
{{--<div class="mt-15 text-center">--}}
{{--    <a href="{{ route('take.test', 5) }}">Go go test</a>--}}

{{--</div>--}}
