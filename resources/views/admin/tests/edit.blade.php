@extends('layouts.admin', ['page_title' => trans('admin.edit_test')])
@section('content')

    <x-form.main title="{{ trans('admin.edit_test') }}">

        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
              action="{{route('admin.tests.update', $test->id)}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="temp_file_selector" id="temp_file_selector" value="{{uniqid()}}">
@if ($errors->any())
    @foreach($errors->all() as $error)
        {{ $error }}
    @endforeach
@endif
            <div class="border py-5 rounded">
                <x-form.languages-tabs/>

                <div class="tab-content" id="pills-tabContent">
                    @foreach(LaravelLocalization::getSupportedLocales() as $key  => $lang)
                        <x-form.languages-tabs-contents :key="$key">

                            <x-form.text-input-translation type="text" label="{{trans('test.title')}}"
                                                           :key="$key" name="title" :targetModel="$test"/>

                            <x-form.text-area-translation label="{{ trans('article.content') }}" name="description"
                                                          :key="$key" class="editor with-file-explorer"
                                                          :targetModel="$test"/>

                            <x-form.text-input-translation type="text"
                                                           label="{{trans('article.keywords')}} ({{ trans('article.preferable_to_choose_5_words_at_most')}})"
                                                           :key="$key" name="slug" :targetModel="$test"/>

                            <x-form.text-area-translation
                                label="{{ trans('article.description') }} ({{ trans('article.this_will_appear_in_search_engines') }})"
                                name="meta_description"
                                :key="$key" :targetModel="$test"/>

                        </x-form.languages-tabs-contents>

                    @endforeach
                </div>
            </div>

            <x-form.select label="{{ trans('admin.categories') }}" name="test_category_id" required
                           :options="$categories" :first-option="trans('admin.choose_category')"
                           :targetModel="$test"/>

            <x-form.text-input name="score" :label="trans('admin.score')" type="number" :targetModel="$test"/>

            <x-form.text-input name="duration" :label="trans('admin.duration')" type="number" :targetModel="$test"/>

            <x-form.text-input label="{{ trans('article.image') }}" name="image" type="file"
                               accept="image/*" :targetModel="$test"/>

            @php
                $options = collect([
                                (object) ['id' => '0', 'name' => trans('No')],
                                (object) ['id' => '1', 'name' => trans('Yes')],
                           ]);
            @endphp
            <x-form.select label="{{ trans('article.publish') }}" name="published"
                           :options="$options" :targetModel="$test"
            />

            <div class="d-flex mt-3">
                <x-form.submit-button title="{{ trans('article.publish') }}" class="btn-success"/>
            </div>

        </form>

    </x-form.main>

@endsection
