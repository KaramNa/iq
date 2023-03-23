@props(['name', 'label', 'key', 'targetModel' => null])
<x-form.input-label :name="$name" :label="$label" :key="$key">

        <textarea
            id="{{ $key }}[{{$name}}]"
            name="{{ $key }}[{{$name}}]"
            rows="5"
            style="direction: {{ $key == 'ar' ? 'rtl' : 'ltr' }}"
            {{ $attributes->class(['form-control', 'char-counts']) }}
        >{{old($key . '.' . $name, $targetModel?->translate($key)->{$name})}}</textarea>

</x-form.input-label>
