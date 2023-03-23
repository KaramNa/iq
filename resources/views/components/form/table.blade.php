@props(['columns', 'targetModel'])
<div class="col-12 mt-3 overflow-auto">
    <div class="col-12 p-0">
        <table class="table table-bordered  table-hover">

            <thead>
            <tr>
                @foreach($columns as $column)
                    <th scope="col">{{$column}}</th>
                @endforeach
            </tr>
            </thead>

            <tbody>
            {{ $slot }}
            </tbody>
        </table>
        <div class="col-12 px-0 py-2">
            {{$targetModel->appends(request()->query())->render() }}
        </div>
    </div>
</div>
