@extends('layouts.admin', ['page_title' => __('admin.categories')])
@section('content')
    <x-form.main title="{{ trans('admin.categories') }}">

        <x-form.index :label="trans('admin.add_category')" permission="categories-create"
                      :route="route('admin.categories.create')"/>

        @php
            $columns = [
                'id' =>'#',
                'image' => trans('admin.image'),
                'name' => trans('admin.name'),
                'articles' => trans('admin.articles'),
                'actions' => trans('admin.actions'),
                ];
        @endphp

        <x-form.table :columns="$columns" :targetModel="$categories">

            @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>

                    <td><img src="{{$category->image()}}" style="width:40px"></td>
                    <td>{{$category->name}}</td>
                    <td>
                        <a href="{{route('admin.articles.index',['category_id'=>$category->id])}}">{{$category->articles_count}}</a>
                    </td>

                    <td class="row d-flex">

                        <x-form.action-button :route="route('admin.categories.edit',['category'=>$category->id])"
                                              class="btn-outline-primary" icon="fal fa-edit" permission="categories-update"
                                              :title="trans('admin.update')"
                        />

                        <x-form.action-button
                            class="btn-outline-danger" icon="fal fa-trash" permission="categories-delete"
                            :delete-form="true" model-name="categories"
                            :target-model="$category"
                            :title="trans('admin.delete')"
                        />

                    </td>
                </tr>
            @endforeach

        </x-form.table>
    </x-form.main>

@endsection
