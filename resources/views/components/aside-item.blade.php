@props(['text', 'route' => '#', 'countLabel' => 0, 'icon', 'logout' => false])
<a href="{{ $route }}" class="col-12 px-0"
   @if($logout)
       onclick="document.getElementById('logout-form').submit();"
    @endif>
    <div class="col-12 item-container px-0 d-flex">
        <div style="width: 50px" class="px-3 text-center">
            <span class="{{ $icon }} font-2"> </span>
        </div>
        <div style="width: calc(100% - 50px)" class="px-2 item-container-title">
            {{ $text }}
            @if ($countLabel !=0)
                <span
                    style="background: #d34339;border-radius: 2px;color:var(--background-1);display: inline-block;font-size: 11px;text-align: center;padding: 1px 5px;margin: 0px 8px">
                {{ $countLabel }}
                </span>
            @endif
        </div>
    </div>
</a>
