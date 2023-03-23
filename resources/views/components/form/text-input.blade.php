@props(['name', 'label', 'type', 'id' => null , 'targetModel' => null])
<x-form.input-label :name="$name" :label="$label">
    <div {{ $type == 'file' ? 'class=col-6' : '' }}>
        <input
            type="{{$type}}"
            id="{{ $id ?? $name}}"
            name="{{$name}}"
            value="{{ old($name, $targetModel ?? '') }}"
            {{ $attributes->class(['form-control', $type == 'text' ?'char-counts' : '']) }}
        >
        @if(isset($targetModel->image) && $name == 'image')
            <div class="col-12 py-2">
                <img src="{{$targetModel->image()}}" style="width:180px;">
            </div>
        @endif
    </div>

</x-form.input-label>
