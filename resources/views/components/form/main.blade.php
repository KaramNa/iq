@props(['title'])
<div class="col-12 py-0 px-3 row">
    <div class="col-12  pt-4 bg-white">
        <div class="col-12 px-3">
            <h3 class="m-0 py-2">{{ $title }}</h3>
        </div>
        <div class="col-12 col-lg-11 px-3 py-5">
            {{ $slot }}
        </div>

    </div>
</div>
