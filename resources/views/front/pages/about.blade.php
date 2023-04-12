@extends('layouts.app',['page_title'=>"من نحن"])
@section('content')
    <div class="col-12 p-0">
        <div class=" p-0 container">
            <div class="col-12 p-2 p-lg-3 row">
                <div class="col-12 px-2 pt-5 pb-3">
                    <div class="col-12 p-0 font-4">
                        <span class="start-head"></span> من نحن
                    </div>
                </div>
                <div class="col-12 col-lg-8 p-2">
                    {!!$settings['about_page']!!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#share-bar').share();
    </script>
@endsection
