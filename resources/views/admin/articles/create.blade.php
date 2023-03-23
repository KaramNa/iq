@extends('layouts.admin', ['page_title' => __('admin.add_article')])
@section('content')

    <x-form.main title="{{ trans('admin.add_article') }}">

        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
              action="{{route('admin.articles.store')}}">
            @csrf
            <input type="hidden" name="temp_file_selector" id="temp_file_selector" value="{{uniqid()}}">

            <div class="border py-5 rounded">
                <x-form.languages-tabs/>

                <div class="tab-content" id="pills-tabContent">
                    @foreach(LaravelLocalization::getSupportedLocales() as $key  => $lang)
                        <x-form.languages-tabs-contents :key="$key">

                            <x-form.text-input-translation type="text" label="{{trans('article.title')}}"
                                                           :key="$key" name="title"/>

                            <x-form.text-area-translation label="{{ trans('article.content') }}" name="description"
                                                          :key="$key" class="editor with-file-explorer"/>

                            <x-form.text-input-translation type="text"
                                                           label="{{trans('article.keywords')}} ({{ trans('article.preferable_to_choose_5_words_at_most')}})"
                                                           :key="$key" name="slug"/>

                            <x-form.text-area-translation
                                label="{{ trans('article.description') }} ({{ trans('article.this_will_appear_in_search_engines') }})"
                                name="meta_description"
                                :key="$key"/>

                        </x-form.languages-tabs-contents>

                    @endforeach
                </div>
            </div>

            <x-form.select label="{{ trans('admin.categories') }}" name="category_id[]" class="select2-select" required
                           multiple :options="$categories"
            />

            <x-form.select label="{{ trans('admin.tags') }}" name="tag_id[]" class="select2-select"
                           multiple size="1" :options="$tags"
            />

            <x-form.text-input label="{{ trans('article.image') }}" name="image" type="file"
                               accept="image/*"/>

            @php
                $options = collect([
                                (object) ['id' => '0', 'name' => trans('No')],
                                (object) ['id' => '1', 'name' => trans('Yes')],
                           ]);
            @endphp
            <x-form.select label="{{ trans('article.featured') }}" name="is_featured"
                           :options="$options"
            />

            <div class="d-flex mt-3">
                <x-form.submit-button title="{{ trans('article.publish') }}" class="btn-success"/>
                <x-form.submit-button title="{{ trans('article.draft') }}" class="btn-danger mx-5" name="draft"/>
            </div>

        </form>

    </x-form.main>

@endsection
