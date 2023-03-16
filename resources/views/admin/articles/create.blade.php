@extends('layouts.admin', ['page_title' => __('admin.add_article')])
@section('content')

    <div class="col-12 p-3">
        <div class="col-12 p-0">

            <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
                  action="{{route('admin.articles.store')}}">
                @csrf
                <input type="hidden" name="temp_file_selector" id="temp_file_selector" value="{{uniqid()}}">

                <div class="col-12 p-0 main-box">

                    <div class="col-12 px-0">
                        <div class="col-12 px-3 py-3">
                            <span class="fas fa-info-circle"></span>
                            @lang('admin.add_article')
                        </div>
                        <div class="col-12 divider"></div>
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
                                                @lang('article.title')
                                            </label>
                                            <div class="col-12 pt-3">
                                                <input
                                                    type="text"
                                                    id="{{ $key }}[title]"
                                                    name="{{ $key }}[title]"
                                                    class="form-control"
                                                    value="{{ old($key . '.title') }}"
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
                                                @lang('article.content')
                                            </label>
                                            <div class="col-12 pt-3">
                                                <textarea id="{{ $key }}[description]" name="{{ $key }}[description]"
                                                          class="editor with-file-explorer">
                                                    {{ old($key . '.description') }}

                                                </textarea>
                                            </div>
                                        </div>
                                        @error("{$key}.description")
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                        @enderror

                                        <div class="col-12 p-2">
                                            <label for="{{ $key }}[slug]" class="col-12">
                                                @lang('article.keywords')
                                                (@lang('article.preferable_to_choose_5_words_at_most'))
                                            </label>
                                            <div class="col-12 pt-3">
                                                <input type="text"
                                                       id="{{ $key }}[slug]"
                                                       name="{{ $key }}[slug]"
                                                       class="form-control"
                                                       value="{{ old($key . '.slug') }}"
                                                       style="direction: {{ $key == 'ar' ? 'rtl' : 'ltr' }}"
                                                >
                                            </div>
                                        </div>
                                        @error("{$key}.slug")
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
                                                >{{ old($key . '.meta_description') }}</textarea>
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
                            <label for="category_id" class="col-12">
                                @lang('admin.categories')
                            </label>
                            <div class="col-12 pt-3">
                                <select class="form-control select2-select"
                                        id="category_id"
                                        size="1"
                                        name="category_id[]"
                                        required
                                        multiple
                                >

                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}"
                                            @selected(in_array($category->id, old('category_id') ?? []))
                                        >
                                            {{$category->title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-12 p-2">
                            <label for="tag_id">@lang('admin.tags')</label>
                            <div class="col-12 pt-3">
                                <select class="form-control select2-select"
                                        id="tag_id"
                                        name="tag_id[]"
                                        size="1"
                                        multiple
                                >
                                    @foreach($tags as $tag)
                                        <option value="{{$tag->id}}"
                                            @selected(in_array($tag->id, old('tag_id') ?? []))
                                        >
                                            {{$tag->name}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 p-2">
                            <div class="col-12">
                                @lang('article.main_image')
                            </div>
                            <div class="col-12 pt-3">
                                <input type="file" name="main_image" class="form-control" accept="image/*">
                            </div>
                            <div class="col-12 pt-3">
                            </div>
                        </div>

                        <div class="col-12 p-2">
                            <label for="is_featured" class="col-12">
                                @lang('article.featured')
                            </label>
                            <div class="col-12 pt-3">
                                <select class="form-control" id="is_featured" name="is_featured">
                                    <option @selected(old('is_featured') == 0 ) value="0">
                                        @lang('No')
                                    </option>
                                    <option @selected(old('is_featured') == 1 ) value="1">
                                        @lang('Yes')
                                    </option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 p-3">
                    <button class="btn btn-success" id="submitEvaluation">@lang('article.publish')</button>
                    <button class="btn btn-danger mx-5" id="submitEvaluation" name="draft">@lang('article.draft')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
