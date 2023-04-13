@extends('layouts.admin',['page_title' => trans('admin.questions')])
@section('content')
    <x-form.main title="{{ trans('admin.questions') }}">
        <x-form.index :label="trans('admin.add_question')" permission="tests-create"
                      :route="route('admin.questions.create', ['test_id' => request()->get('test_id')])"/>

        <div class="col-12 border-top mt-5">

            <form method="GET" class="pt-3">
                <span>@lang('admin.translated_questions') </span>
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
                trans('admin.image'),
                trans('admin.question'),
                trans('admin.test'),
                trans('admin.level'),
                trans('admin.weight'),
                trans('admin.status'),
                trans('admin.actions'),
                ];
        @endphp

        <x-form.table :columns="$columns" :targetModel="$questions" model-name="quetions">

            @foreach($questions as $question)
                <tr>
                    <td>{{$question->id}}</td>
                    <td><img src="{{$question->image()}}" style="width:40px"></td>
                    <td>{!! $question->translate(request()->lang)->content !!}</td>
                    <td>
                        <a href="{{ route('admin.questions.index',['test_id' => $question->test->id]) }}">
                            {{$question->test->title}}
                        </a>
                    </td>

                    <td>
                        {{ $question->level }}
                    </td>
                    <td>{{$question->weight}}</td>

                    <td>
                        @if($question->active == 1)
                            @lang('admin.published')
                        @else
                            @lang('admin.draft')
                        @endif
                    </td>
                    <td class="row d-flex">

                        <x-form.action-button :route="route('admin.questions.edit',['question'=>$question->id])"
                                              class="btn-outline-primary" icon="fal fa-edit" permission="tests-update"
                                              :title="trans('admin.update')"/>

                        <x-form.action-button
                            class="btn-outline-danger" icon="fal fa-trash" permission="tests-delete"
                            :delete-form="true" model-name="questions"
                            :target-model="$question" :title="trans('admin.delete')"/>

                    </td>
                </tr>
            @endforeach

        </x-form.table>

    </x-form.main>

@endsection
<script type="module">
    @if($errors->any())
        @foreach($errors->all() as $error)
            @php
                toastr()->error(
                        __('You should put the test_id in the url!')
                    );
                @endphp
        @endforeach
    @endif
</script>
