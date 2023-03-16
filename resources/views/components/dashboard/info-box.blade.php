<div class="col-12 col-sm-6 col-lg-4 col-xl-3 col-xxl-2 px-2 my-2">
    <div class="col-12 px-0 py-1 d-flex main-box-wedit">
        <div style="width: 65px;" class="p-2">
            <div class="col-12 px-0 text-center d-flex align-items-center justify-content-center"
                 style="background: #0194fe;color: #fff;border-radius: 50%;width: 55px;height:55px">
                <span class="fal fa-users font-5"></span>
            </div>
        </div>
        <div style="width: calc(100% - 70px)" class="py-2 text-center">
            <a class="font-1" href="{{route($route)}}" style="color: #212529">
                @lang($text)
                <h6 class="font-3 text-center">{{ $count }}</h6>
            </a>
        </div>
    </div>
</div>
