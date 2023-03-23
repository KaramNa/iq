@extends('layouts.admin', ['page_title' => __('admin.edit_announcement')])
@section('content')

    <x-form.main title="{{ trans('admin.edit_announcement') }}">
        <form class="col-12" method="POST" action="{{route('admin.announcements.update',$announcement)}}"
              enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <x-form.text-input label="{{ trans('admin.announcement_title') }}" name="title" type="text"
                               :target-model="$announcement" required/>

            <x-form.text-area label="{{ trans('admin.description') }}" name="description" :target-model="$announcement" required/>

            <x-form.text-input label="{{ trans('admin.start_date') }}" name="start_date" type="datetime-local" :target-model="$announcement"/>

            <x-form.text-input label="{{ trans('admin.expiry_date') }}" name="end_date" type="datetime-local" :target-model="$announcement"/>

            <x-form.text-input label="{{ trans('admin.url') }}" name="url" type="url" :target-model="$announcement" required/>

            <x-form.select label="{{ trans('admin.ad_location') }}" name="location" required :options="$options"
                           required="required" firstOption="{{ trans('admin.ad_select_location.label') }}" :target-model="$announcement"/>

            <x-form.radio-input label="{{ trans('admin.open_in_a_new_window') }}" id="flexSwitchCheckDefault"
                                name="open_url_in" :target-model="$announcement"/>

            <x-form.text-input label="{{ trans('admin.image') }}" name="image" type="file" accept="image/*" :target-model="$announcement"/>

            <x-form.submit-button title="{{trans('Save')}}" class="btn-success"/>

        </form>

    </x-form.main>

@endsection
