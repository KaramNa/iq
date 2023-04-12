@props(['key', 'code' => ''])
<div class="tab-pane fade show {{ app()->getLocale() == $key ? 'active' : ''}}"
     id="pills-{{ $key }}{{ $code }}" role="tabpanel"
     aria-labelledby="pills-{{ $key }}-tab{{ $code }}"
>
    {{ $slot }}
</div>

