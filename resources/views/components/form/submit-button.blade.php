@props(['title'])
<div class="pt-3">
    <button {{ $attributes->class(['btn pb-2 p-2']) }}>
        {{ $title }}
    </button>
</div>
