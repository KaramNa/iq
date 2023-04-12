@extends('layouts.admin', ['page_title' => __('admin.add_category')])
@section('content')
    <x-form.main title="{{ trans('admin.add_category') }}">

        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
              action="{{route('admin.test-categories.store')}}">
            @csrf
            <input type="hidden" name="temp_file_selector" id="temp_file_selector" value="{{uniqid()}}">

            <div class="border py-5 rounded">
                <x-form.languages-tabs/>

                <div class="tab-content" id="pills-tabContent">
                    @foreach(LaravelLocalization::getSupportedLocales() as $key  => $lang)
                        <x-form.languages-tabs-contents :key="$key">

                            <x-form.text-input-translation type="text" label="{{ trans('admin.name')}}" :key="$key"
                                                           name="name"/>

                            <x-form.text-area-translation label="{{ trans('admin.description') }}" name="description"
                                                          :key="$key" class="editor with-file-explorer"/>

                            <x-form.text-area-translation
                                label="{{ trans('admin.meta_description') }} ({{ trans('article.this_will_appear_in_search_engines') }})"
                                name="meta_description"
                                :key="$key"/>

                        </x-form.languages-tabs-contents>

                    @endforeach
                </div>
            </div>

            <div class="mt-3">
                <x-form.submit-button title="{{ trans('Save') }}" class="btn-success"/>
            </div>

        </form>

    </x-form.main>

@endsection