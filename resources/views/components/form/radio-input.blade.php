@props(['name', 'label', 'id', 'targetModel' => null])
<x-form.input-label :name="$name" :label="$label">

    <div class="form-switch">
        <input name="{{$name}}"
               class="form-check-input"
               type="checkbox"
               id="{{$id}}"
               {{old($name, $targetModel ?? '')=="NEW_WINDOW"?"checked":""}}
               style="width: 50px;height:25px"
               value="NEW_WINDOW">
    </div>

</x-form.input-label>
