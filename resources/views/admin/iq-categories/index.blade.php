@extends('layouts.admin', ['page_title' => __('admin.categories')])
@section('content')
    <x-form.main title="{{ trans('admin.categories') }}">

        <x-form.index :label="trans('admin.add_category')" permission="categories-create"
                      :route="route('admin.test-categories.create')"/>

        @php
            $columns = [
                'id' =>'#',
                'name' => trans('admin.name'),
                'tests' => trans('admin.tests'),
                'actions' => trans('admin.actions'),
                ];
        @endphp

        <x-form.table :columns="$columns" :targetModel="$categories">

            @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>

                    <td>{{$category->name}}</td>
                    <td>
                        <a href="{{route('admin.tests.index',['test_category_id'=>$category->id])}}">{{$category->tests_count}}</a>
                    </td>

                    <td class="row d-flex">

                        <x-form.action-button :route="route('admin.test-categories.edit',['test_category'=>$category->id])"
                                              class="btn-outline-primary" icon="fal fa-edit" permission="test-categories-update"
                                              :title="trans('admin.update')"
                        />

                        <x-form.action-button
                            class="btn-outline-danger" icon="fal fa-trash" permission="test-categories-delete"
                            :delete-form="true" model-name="test-categories"
                            :target-model="$category"
                            :title="trans('admin.delete')"
                        />

                    </td>
                </tr>
            @endforeach

        </x-form.table>
    </x-form.main>

@endsection
