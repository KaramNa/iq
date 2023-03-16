@extends('layouts.admin' ,['page_title' => __('admin.edit_link')])
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">
            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                  action="{{route('admin.menu-links.update',$menuLink)}}">
                @csrf
                @method("PUT")
                <input type="hidden" name="menu_id" value="{{$menuLink->menu_id}}">
                <div class="col-12 col-lg-8 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> إضافة جديد
                        </div>
                        <div class="col-12 divider" style="min-height: 2px;"></div>
                    </div>
                    <div class="col-12 p-3 row">


                        <div class="border p-2 rounded">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                @foreach(LaravelLocalization::getSupportedLocales() as $key => $lang)
                                    <li class="nav-item" role="presentation">
                                        <button
                                            id="pills-{{ $key }}-tab"
                                            class="nav-link {{ app()->getLocale() == $key ? 'active' : ''}}"
                                            data-bs-toggle="pill"
                                            data-bs-target="#pills-{{ $key }}"
                                            type="button"
                                            role="tab"
                                            aria-controls="pills-{{ $key }}"
                                            aria-selected="true"
                                        >{{ $lang['native'] }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                @foreach(LaravelLocalization::getSupportedLocales() as $key  => $lang)
                                    <div class="tab-pane fade show {{ app()->getLocale() == $key ? 'active' : ''}}"
                                         id="pills-{{ $key }}" role="tabpanel"
                                         aria-labelledby="pills-{{ $key }}-tab"
                                    >
                                        <div class="col-12 p-2">
                                            <label for="{{ $key }}[title]" class="col-12">
                                                عنوان الرابط
                                            </label>
                                            <div class="col-12 pt-3">
                                                <input
                                                    type="text"
                                                    id="{{ $key }}[title]"
                                                    name="{{ $key }}[title]"
                                                    class="form-control"
                                                    value="{{ old($key . '.title', $menuLink->translate($key)->title) }}"
                                                    style="direction: {{ $key == 'ar' ? 'rtl' : 'ltr' }}"
                                                >
                                            </div>
                                        </div>
                                        @error("{$key}.title")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                <label for="type">النوع</label>
                                <select class="form-control mt-3" name="type" id="type">
                                    <option value="CUSTOM_LINK" @selected(old('type', $menuLink->type)=="CUSTOM_LINK")>
                                        رابط
                                        مخصص
                                    </option>
                                    <option value="PAGE" @selected(old('type', $menuLink->type)=="PAGE")>صفحة</option>
                                    <option value="CATEGORY" @selected(old('type', $menuLink->type)=="CATEGORY")>قسم
                                    </option>
                                </select>
                            </div>
                            @error("type")
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                <label for="type_id">القيمة</label>
                                <select class="form-control  mt-3" name="type_id" id="type_id" required>
                                </select>
                            </div>
                            @error("type_id")
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                <label for="url">الرابط</label>
                                <input type="text" name="url" required class="form-control mt-3"
                                       value="{{old('url', $menuLink->url)}}"
                                       id="url">
                            </div>
                            @error("url")
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12 col-lg-6 p-2">
                            <div class="col-12">
                                <label for="icon">الأيقونة</label>
                                <input type="text" name="icon" class="form-control mt-3"
                                       value="{{old('icon', $menuLink->icon)}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-3">
                    <button class="btn btn-success" id="submitEvaluation">حفظ</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.slim.min.js"
            integrity="sha256-a2yjHM4jnF9f54xUQakjZGaqYs/V1CYvWpoqZzC2/Bw=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('#type').change(function () {
            var type = $('#type').val();
            $.ajax({
                method: "POST",
                url: "{{route('admin.menu-links.get-type')}}",
                data: {
                    type: type, _token: "{{ csrf_token() }}"
                }
            }).done(function (response) {
                $('#type_id').empty();
                $('#type_id').append($("<option></option>").attr({
                    "value": '',
                    'selected': ''
                }).text('اختر من القائمة'));
                console.log(response);
                for (var i = 0; i < response.length; i++) {
                    $('#type_id').append($("<option></option>").attr("value", response[i].id).attr("data-title", response[i].title).attr("data-url", "/" + response[i].slug).text(response[i].title));
                }
            });
        });
        $('#type_id').on('change', function () {
            $('#url').val($('option:selected', this).attr('data-url'));
            $('#title').val($('option:selected', this).attr('data-title'));
        });
    </script>
@endsection
