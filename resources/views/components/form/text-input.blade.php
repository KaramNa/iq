@props(['name', 'label', 'type', 'id' => null , 'targetModel' => null])

<x-form.input-label :name="$name" :label="$label">
    <div {{ in_array($type, ['file', 'number']) ? 'class=col-xl-6' : '' }}>
        <input
            type="{{$type}}"
            id="{{ $id ?? $name}}"
            name="{{$name}}"
            value="{{ old($name, $targetModel ?? '') }}"
            {{ $attributes->class(['form-control', $type == 'text' ?'char-counts' : '']) }}
        >

        @if(isset($targetModel->image) && str_contains($name, 'image'))
            <div class="col-12 py-2">
                <img src="{{$targetModel->image()}}" style="width:180px;">
            </div>
        @endif
    </div>

</x-form.input-label>
