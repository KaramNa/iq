@props(['key' => ''])
<ul class="nav nav-pills mb-3 pe-0" id="pills-tab{{ $key }}" role="tablist">
    @foreach(LaravelLocalization::getSupportedLocales() as $code => $lang)
        <li class="nav-item" role="presentation">
            <button
                id="pills-{{ $code }}-tab{{ $key }}"
                class="nav-link {{ app()->getLocale() == $code ? 'active' : ''}}"
                data-bs-toggle="pill"
                data-bs-target="#pills-{{ $code }}{{ $key }}"
                type="button"
                role="tab"
                aria-controls="pills-{{ $code }}"
                aria-selected="true"
            >{{ $lang['native'] }}
            </button>
        </li>
    @endforeach
</ul>
