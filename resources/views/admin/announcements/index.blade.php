@extends('layouts.admin', ['page_title' => __('admin.announcements')])
@section('content')
    <x-form.main title="{{ trans('admin.announcements') }}">

        <x-form.index :label="trans('admin.add_announcement')" permission="announcements-create"
                      :route="route('admin.announcements.create')"/>

        @php
            $columns = [
                'id' =>'#',
                'title' => trans('admin.title'),
                'description' => trans('admin.description'),
                'url' => trans('admin.link'),
                'actions' => trans('admin.actions'),
                ];
        @endphp

        <x-form.table :columns="$columns" :targetModel="$announcements">

            @foreach($announcements as $announcement)
                <tr>
                    <td>{{ $announcement->id }}</td>
                    <td>{{$announcement->title}}</td>
                    <td>{{$announcement->description}}</td>
                    <td>
                        <a href="{{$announcement->url}}"
                           target="_block">{{$announcement->url}}
                        </a>
                    </td>
                    <td class="row d-flex">

                        <x-form.action-button :route="route('admin.announcements.edit',$announcement)"
                                              class="btn-outline-primary" icon="fal fa-edit" permission="announcements-update"
                                              :title="trans('admin.update')"
                        />

                        <x-form.action-button
                            class="btn-outline-danger" icon="fal fa-trash" permission="announcements-delete"
                            :delete-form="true" model-name="announcements"
                            :target-model="$announcement"
                            :title="trans('admin.delete')"
                        />

                    </td>
                </tr>
            @endforeach

        </x-form.table>

    </x-form.main>

@endsection
