<div class="col-auto  d-flex align-items-center px-1 ">
    <a
        class="d-flex align-items-center py-2 px-3 top-navbar-link rounded"
        style="color: inherit;"
        type="button" id="language-dropdown"
        data-bs-toggle="dropdown" aria-expanded="false"
    >
        {{ LaravelLocalization::getCurrentLocaleNative()  }}
    </a>

    <ul class="dropdown-menu" aria-labelledby="language-dropdown">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            @if ($localeCode !== app()->getLocale())
                <li>
                    <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                       href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                        {{ $properties['native'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>

</div>
