@props(['name', 'label', 'options', '$firstOption', 'targetModel' => null, 'relation' => null])
<x-form.input-label :name="$name" :label="$label">
    <div class="col-6">
        <select name="{{$name}}"
                id="{{$name}}"
            {{ $attributes->class(['form-control']) }}>
            @if (isset($firstOption))
                <option disabled hidden selected value>{{ $firstOption }}</option>
            @endif

            @foreach($options as $option)
                <option
                    value="{{ $option->id }}"
                @if (str_contains($attributes, 'select2-select'))
                    @selected(in_array($option->id, old(str_replace(['[',']'], '', $name) , $targetModel?->{$relation}->pluck('id')->toArray()) ?? []))
                    @else
                    {{ old($name, $targetModel->{$name} ?? '') == "$option->id" ? "selected" : "" }}
                    @endif
                >
                {{ $option->name }}

            @endforeach

        </select>
    </div>

</x-form.input-label>

