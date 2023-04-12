@props(['text', 'icon'])
<div class="col-12 px-0" style="cursor: pointer;">
    <div class="col-12 item px-0 d-flex row ">
        <div class="col-12 d-flex px-0 item-container">
            <div style="width: 50px" class="px-3 text-center">
                <span class="{{ $icon }} font-2"> </span>
            </div>
            <div style="width: calc(100% - 50px)" class="px-2 item-container-title has-sub-menu">
                {{ $text }}
            </div>
        </div>
        <div class="col-12 px-0">
            <ul class="sub-item font-1" style="list-style:none;">

                {{$slot}}

            </ul>
        </div>
    </div>
</div>

