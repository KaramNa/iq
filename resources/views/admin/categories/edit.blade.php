@extends('layouts.admin', ['page_title' => __('admin.edit_category')])
@section('content')
    <div class="col-12 p-3">
        <div class="col-12 col-lg-12 p-0 ">

            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                  action="{{route('admin.categories.update',$category->id)}}">
                @csrf
                @method("PUT")
                <input type="hidden" name="temp_file_selector" id="temp_file_selector" value="{{uniqid()}}">
                <div class="col-12 col-lg-8 p-0 main-box">
                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span> @lang('admin.edit_category')
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
                                                @lang('category.title')
                                            </label>
                                            <div class="col-12 pt-3">
                                                <input
                                                    type="text"
                                                    id="{{ $key }}[title]"
                                                    name="{{ $key }}[title]"
                                                    class="form-control"
                                                    value="{{ old($key . '.title', $category->translate($key)->title) }}"
                                                    style="direction: {{ $key == 'ar' ? 'rtl' : 'ltr' }}"
                                                >
                                            </div>
                                        </div>
                                        @error("{$key}.title")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="col-12 p-2"
                                             onclick="tinymce.activeEditor.execCommand('mceDirection{{ $key == 'ar' ? 'RTL' : 'LTR' }}')">
                                            <label for="{{ $key }}[description]" class="col-12">
                                                @lang('admin.description')
                                            </label>
                                            <div class="col-12 pt-3">
                                                <textarea id="{{ $key }}[description]" name="{{ $key }}[description]"
                                                          class="editor with-file-explorer">
                                                    {{ old($key . '.description', $category->translate($key)->description) }}

                                                </textarea>
                                            </div>
                                        </div>
                                        @error("{$key}.description")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="col-12 p-2">
                                            <label for="{{ $key }}[meta_description]" class="col-12">
                                                @lang('article.description')
                                                (@lang('article.this_will_appear_in_search_engines'))
                                            </label>
                                            <div class="col-12 pt-3">
                                                <textarea id="{{ $key }}[meta_description]"
                                                          name="{{ $key }}[meta_description]"
                                                          class="form-control"
                                                          style="direction: {{ $key == 'ar' ? 'rtl' : 'ltr' }}"
                                                >{{ old($key . '.meta_description', $category->translate($key)->meta_description) }}</textarea>
                                            </div>
                                        </div>
                                        @error("{$key}.meta_description")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-12 p-2">
                            <div class="col-12">
                                الشعار
                            </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="image" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12 pt-3">
                                <img src="{{$category->image()}}" style="width:100px">
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
