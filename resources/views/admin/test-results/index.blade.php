@extends('layouts.admin',['page_title' => __('admin.test_results')])
@section('content')
    <x-form.main title="{{ trans('admin.test_results') }}">
        <x-form.index />

        @php
            $columns = [
                '#',
                trans('admin.test'),
                trans('admin.name') ,
                trans('admin.age') ,
                trans('admin.country') ,
                trans('admin.score') ,
                trans('admin.actions'),
                ];
        @endphp
        <x-form.table :columns="$columns" :targetModel="$testResults" model-name="article">

            @foreach($testResults as $testResult)
                <tr>
                    <td>{{$testResult->id}}</td>
                    <td>{{\App\Models\Test::find($testResult->test_id)->title}}</td>
                    <td>{{$testResult->test_taker_name}}</td>
                    <td>{{$testResult->test_taker_age}}</td>
                    <td>{{$testResult->test_taker_country ?? 'unknown'}}</td>
                    <td>{{$testResult->score}}</td>
                    <td class="row d-flex">
                        <x-form.action-button
                            class="btn-outline-danger" icon="fal fa-trash" permission="test-results-delete"
                            :delete-form="true" model-name="test-results"
                            :target-model="$testResult" :title="trans('admin.delete')"/>
                    </td>
                </tr>
            @endforeach


        </x-form.table>
    </x-form.main>

@endsection
