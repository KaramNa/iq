@props(['permission', 'text', 'route', 'countLabel' => 0, 'icon'])

@can('categories-read')
    <li>
        <a href="{{ $route }}" style="font-size: 16px;">
            <span class="{{ $icon }} px-2" style="width: 28px;font-size: 15px;"></span>
            {{ $text }}

            @if ($countLabel != 0)
                <span
                    style="background: #d34339;border-radius: 2px;color:var(--background-1);display: inline-block;font-size: 11px;text-align: center;padding: 1px 5px;margin: 0px 8px">
                {{ $countLabel }}
            </span>
            @endif

        </a>
    </li>
@endcan
