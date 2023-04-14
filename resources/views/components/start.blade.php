<section class="wrapper bg-light">
    <style type="text/css">
        .features-list i {
            width: 50px;
        }
    </style>
    <div class="container">
           <div class="row gx-lg-8 gx-xl-12 gy-10 align-items-center">
            <div class="col-lg-5 position-relative order-lg-2 px-0">
                <div class="shape primary rellax w-16 h-20" data-rellax-speed="1"
                     style="top: 3rem; left: 5.5rem"></div>
                <div class="overlap-grid">
                    <div class="item">
                        <figure class="rounded shadow"><img src="/images/{{app()->getLocale()}}_scale.jpg" alt=""></figure>
                    </div>

                </div>
            </div>
            <!--/column -->
            <div class="col-lg-7">


                <h1 class="display-4 mb-3">
                    <img src="/images/brainTrain.png" style="width: 80px;height: 80px;border-radius: 50%;"
                         alt=""/>
                    IQFreeTest
                </h1>
                <p class="lead fs-lg" data-delay="1000">
                    @lang('home.bio')
                </p>


                <div class="row gy-3 gx-xl-8">


                    <div class="col-xl-12 px-0">
                        <ul style="list-style:none" class="p-0 features-list">
                            <li class='d-flex align-items-center mb-2'>
                                <i class="fal fa-brain me-2 ms-0 font-4 p-2" style="color:#7cb798"></i>
                                <span>@lang('home.feature1')</span>
                            </li>
                            <li class='d-flex align-items-center mb-2'>
                                <i class="fal fa-brain me-2 ms-0 font-4 p-2" style="color:#7cb798"></i>
                                <span>@lang('home.feature2')</span>
                            </li>
                            <li class='d-flex align-items-center mb-2'>
                                <i class="fal fa-brain me-2 ms-0 font-4 p-2" style="color:#7cb798"></i>
                                <span>@lang('home.feature3')</span>
                            </li>
                            <li class='d-flex align-items-center mb-2'>
                                <i class="fal fa-brain me-2 ms-0 font-4 p-2" style="color:#7cb798"></i>
                                <span>@lang('home.feature4')</span>
                            </li>

                        </ul>
                    </div>

                    <div>
                        <a href="{{route('tests')}}" class="btn btn-primary">@lang('Test Your IQ Now For Free')!</a>
                    </div>
                    <!--/column -->
                </div>
                <!--/.row -->
            </div>
            <!--/column -->
        </div>
        <!--/.row -->
    </div>
    <!-- /.container -->
</section>
