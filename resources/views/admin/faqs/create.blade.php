@extends('layouts.admin', ['page_title' => __('admin.add_faq')])
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">
            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                  action="{{route('admin.faqs.store')}}">
                @csrf
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
                                            <label for="{{ $key }}[question]" class="col-12">
                                                السؤال
                                            </label>
                                            <div class="col-12 pt-3">
                                                <input
                                                    type="text"
                                                    id="{{ $key }}[question]"
                                                    name="{{ $key }}[question]"
                                                    class="form-control"
                                                    value="{{ old($key . '.question') }}"
                                                    style="direction: {{ $key == 'ar' ? 'rtl' : 'ltr' }}"
                                                >
                                            </div>
                                        </div>
                                        @error("{$key}.question")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror


                                        <div class="col-12 p-2">
                                            <label for="{{ $key }}[answer]" class="col-12">
                                                الجواب
                                            </label>
                                            <div class="col-12 pt-3">
                                                <textarea id="{{ $key }}[answer]"
                                                          name="{{ $key }}[answer]" class="form-control"
                                                          style="min-height:150px; direction: {{ $key == 'ar' ? 'rtl' : 'ltr' }}">{{old('answer')}}</textarea>
                                            </div>
                                        </div>
                                        @error("{$key}.answer")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 p-2">
                            <label for="is_featured">
                                مميز
                            </label>
                            <div class="col-12 pt-3">
                                <select class="form-control" name="is_featured" id="is_featured">
                                    <option @selected(old('is_featured',$level??"")=="0" ) value="0">@lang('No')
                                    </option>
                                    <option @selected(old('is_featured',$level??"")=="1" ) value="1">@lang('Yes')
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 p-3">
                    <button class="btn btn-success" id="submitEvaluation">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
