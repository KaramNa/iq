@extends('layouts.admin',['page_title' => trans('admin.tests')])
@section('content')
    <x-form.main title="{{ trans('admin.tests') }}">
        <x-form.index :label="trans('admin.add_test')" permission="tests-create"
                      :route="route('admin.tests.create')"/>

        <div class="col-12 border-top mt-5">

            <form method="GET" class="pt-3">
                <span>@lang('admin.translated_tests') </span>
                @foreach(LaravelLocalization::getSupportedLocales() as $key  => $lang)
                    <button type="submit" name="lang"
                            class="btn-sm btn-outline-dark
                                @if ((request()->lang ?? app()->getLocale()) == $key) active @endif"
                            value="{{ $key }}">{{ $lang['native'] }}
                    </button>
                @endforeach
            </form>

        </div>

        @php
            $columns = [
                '#',
                trans('admin.user'),
                trans('admin.image'),
                trans('admin.title'),
                trans('admin.category'),
                trans('admin.score'),
                trans('admin.status'),
                trans('admin.duration'),
                trans('admin.number_of_questions'),
                trans('admin.actions'),
                ];
        @endphp

        <x-form.table :columns="$columns" :targetModel="$tests" model-name="test">

            @foreach($tests as $test)
                <tr>
                    <td>{{$test->id}}</td>
                    <td>{{$test->user->name}}</td>
                    <td><img src="{{$test->image()}}" style="width:40px"></td>
                    <td>{{$test->translate(request()->lang)->title}}</td>
                    <td>
                        {{$test->testCategory->name}}
                    </td>

                    <td>
                        {{ $test->score }}
                    </td>
                    <td>
                        @if($test->published == 1)
                            @lang('admin.published')
                        @else
                            @lang('admin.draft')
                        @endif
                    </td>
                    <td>{{$test->duration}}</td>
                    <td>{{$test->questions->count()}}</td>
                    <td class="row d-flex">

                        <x-form.action-button :route="route('admin.questions.index',['test_id' => $test->id])"
                                              class="btn-outline-success" icon="fal fa-question" permission="tests-read"
                                              :title="trans('admin.questions')"/>

                        <x-form.action-button :route="route('admin.tests.show',$test->translate(request()->lang)->slug)"
                                              class="btn-outline-success" icon="fal fa-eye" permission="tests-read"
                                              :title="trans('admin.show')"/>


                        <x-form.action-button :route="route('admin.tests.edit',['test'=>$test->id])"
                                              class="btn-outline-primary" icon="fal fa-edit" permission="tests-update"
                                              :title="trans('admin.update')"/>

                        <x-form.action-button
                            class="btn-outline-danger" icon="fal fa-trash" permission="tests-delete"
                            :delete-form="true" model-name="tests"
                            :target-model="$test" :title="trans('admin.delete')"/>

                    </td>
                </tr>
            @endforeach

        </x-form.table>

    </x-form.main>

@endsection
