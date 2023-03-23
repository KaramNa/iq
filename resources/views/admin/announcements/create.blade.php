@extends('layouts.admin', ['page_title' => __('admin.add_announcement')])
@section('content')
    <x-form.main title="{{ trans('admin.add_announcement') }}">
        <form class="col-12" method="POST" action="{{route('admin.announcements.store')}}"
              enctype="multipart/form-data">
            @csrf

            <x-form.text-input label="{{ trans('admin.announcement_title') }}" name="title" type="text"
                               required/>

            <x-form.text-area label="{{ trans('admin.description') }}" name="description" required/>

            <x-form.text-input label="{{ trans('admin.start_date') }}" name="start_date" type="datetime-local"/>

            <x-form.text-input label="{{ trans('admin.expiry_date') }}" name="end_date" type="datetime-local"/>

            <x-form.text-input label="{{ trans('admin.url') }}" name="url" type="url" required/>

            <x-form.select label="{{ trans('admin.ad_location') }}" name="location" required :options="$options"
                           firstOption="{{ trans('admin.ad_select_location.label') }}"/>

            <x-form.radio-input label="{{ trans('admin.open_in_a_new_window') }}" id="flexSwitchCheckDefault"
                                name="open_url_in"/>

            <x-form.text-input label="{{ trans('admin.image') }}" name="image" type="file" accept="image/*"/>

            <x-form.submit-button title="{{trans('Save')}}" class="btn-success"/>

        </form>
    </x-form.main>

@endsection
