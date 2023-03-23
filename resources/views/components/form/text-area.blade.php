@props(['name', 'label', 'targetModel' => null])
<x-form.input-label :name="$name" :label="$label">

        <textarea
            id="{{$name}}"
            name="{{$name}}"
            rows="5"
            {{ $attributes->class(['form-control', 'char-counts']) }}
        >{{old($name, $targetModel ?? '')}}</textarea>

</x-form.input-label>
