@props(['route' => '#', 'icon', 'permission', 'deleteForm' => false, 'modelName' => '', 'targetModel' => '', 'title'])
@can($permission)
    @if ($deleteForm)
        <form method="POST"
              class="d-none"
              action="{{route('admin.' . $modelName . '.destroy',$targetModel->id)}}"
              id="{{ $modelName }}_delete_{{$targetModel->id}}">
            @csrf @method('DELETE')
        </form>
    @endif
    <a href="{{$route}}"
       title="{{ $title }}"
       style="width: 40px;height: 30px;"
       @if ($deleteForm)
           onclick='let result = confirm("{{ trans('admin.delete_confirmation') }}");if (result) {$("#{{ $modelName }}_delete_{{$targetModel->id}}").submit();}'
        @endif
        {{ $attributes->class(['btn btn-sm mx-1 mb-1']) }}>
        <i class="{{ $icon }}" style="line-height: inherit;"></i>
    </a>
@endcan
