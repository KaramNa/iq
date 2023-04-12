@extends('layouts.admin',['page_title' => __('admin.articles')])
@section('content')
    <x-form.main title="{{ trans('iqtest::admin.test_takers') }}">
        <x-form.index />

        @php
            $columns = [
                '#',
                trans('admin.username'),
                trans('lang.email') ,
                trans('admin.actions'),
                ];
        @endphp

        <x-form.table :columns="$columns" :targetModel="$testTakers" model-name="article">


            @foreach($testTakers as $testTaker)
                <tr>
                    <td>{{$testTaker->id}}</td>
                    <td>{{$testTaker->username}}</td>
                    <td>{{$testTaker->email}}</td>
                    <td class="row d-flex">
                        <x-form.action-button :route="route('admin.test-taker.show',$testTaker)"
                                              class="btn-outline-success" icon="fal fa-eye" permission="articles-read"
                                              :title="trans('admin.show')"/>

                        <x-form.action-button
                            class="btn-outline-danger" icon="fal fa-trash" permission="test-takers-delete"
                            :delete-form="true" model-name="test-taker"
                            :target-model="$testTaker" :title="trans('admin.delete')"/>

                    </td>
                </tr>
            @endforeach



        </x-form.table>
    </x-form.main>

@endsection
