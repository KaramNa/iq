@props(['name', 'label', 'id', 'targetModel' => null, 'value' => 'NEW_WINDOW'])
<x-form.input-label :name="$name" :label="$label">
    <div class="form-switch">
        <input name="{{$name}}"
               class="form-check-input"
               type="checkbox"
               id="{{$id}}"
               {{old($name, $targetModel ?? '')==$value?"checked":""}}
               style="width: 50px;height:25px"
               value="{{ $value }}">
    </div>

</x-form.input-label>
