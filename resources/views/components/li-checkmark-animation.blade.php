@props(['text'])
<li class="list-group-item mt-2 d-flex">
    <div class="circle-container">
        <div class="circle-checkmark"></div>
        <svg class="check" viewBox="0 0 30 30">
            <path d="M7,17 L12,22 L23,10"/>
        </svg>
    </div>
    <div class="mx-1"></div>
    <div>{{ $text }}</div>
</li>
