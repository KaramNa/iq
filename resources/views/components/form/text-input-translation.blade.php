@props(['name', 'label', 'type', 'key', 'targetModel' => null])

<x-form.input-label :name="$name" :label="$label" :key="$key">

    <input
        type="{{$type}}"
        id="{{ $key }}[{{$name}}]"
        name="{{ $key }}[{{$name}}]"
        value="{{ old($key . '.' . $name, $targetModel?->translate($key)->{$name}) }}"
        style="direction: {{ $key == 'ar' ? 'rtl' : 'ltr' }}"
        {{ $attributes->class(['form-control', $type == 'text' ?'char-counts' : '']) }}
    >

</x-form.input-label>
