@props(['key'])
<div class="tab-pane fade show {{ app()->getLocale() == $key ? 'active' : ''}}"
     id="pills-{{ $key }}" role="tabpanel"
     aria-labelledby="pills-{{ $key }}-tab"
>
    {{ $slot }}
</div>

