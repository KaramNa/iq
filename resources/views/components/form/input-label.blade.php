@props(['name', 'label', 'key'])
<div class="col-12 mt-4">
    <label for="{{ $name }}">
        {{ $label }}
    </label>
    <div class="mt-2">
        {{$slot}}
    </div>
</div>
@error(( isset($key) ? $key . '.' : '' ) . $name)
<div class="text-danger">
    {{ $message }}
</div>
@enderror
