<ul class="nav nav-pills mb-3 pe-0" id="pills-tab" role="tablist">
    @foreach(LaravelLocalization::getSupportedLocales() as $key => $lang)
        <li class="nav-item" role="presentation">
            <button
                id="pills-{{ $key }}-tab"
                class="nav-link {{ app()->getLocale() == $key ? 'active' : ''}}"
                data-bs-toggle="pill"
                data-bs-target="#pills-{{ $key }}"
                type="button"
                role="tab"
                aria-controls="pills-{{ $key }}"
                aria-selected="true"
            >{{ $lang['native'] }}
            </button>
        </li>
    @endforeach
</ul>
