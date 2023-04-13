@extends('layouts.admin', ['page_title' => trans('admin.edit_question')])
@section('content')

    <x-form.main title="{{ trans('admin.edit_question') }}">

        <form id="validate-form" class="row" enctype="multipart/form-data" method="POST"
              action="{{route('admin.questions.update', $question)}}">
            @csrf
            @method('PUT')
            <input type="hidden" name="temp_file_selector" id="temp_file_selector" value="{{uniqid()}}">
            <input type="hidden" name="test_id" value="{{$question->test->id}}">
            <div>
                <x-form.languages-tabs/>

                <div class="tab-content" id="pills-tabContent">
                    @foreach(LaravelLocalization::getSupportedLocales() as $key  => $lang)
                        <x-form.languages-tabs-contents :key="$key">

                            <x-form.text-area-translation label="{{ trans('article.content') }}" name="content"
                                                          :key="$key" class="editor with-file-explorer"
                                                          :target-model="$question"/>

                        </x-form.languages-tabs-contents>

                    @endforeach
                </div>
            </div>

            <x-form.text-input label="{{ trans('article.image') }}" name="image" type="file"
                               accept="image/*" :target-model="$question"/>

            <x-form.text-input name="level" :label="trans('admin.level')" type="number" :target-model="$question"/>

            <x-form.text-input name="weight" :label="trans('admin.weight')" type="number" :target-model="$question"/>


            @php
                $options = collect([
                                (object) ['id' => '1', 'name' => trans('Yes')],
                                (object) ['id' => '0', 'name' => trans('No')],
                           ]);
            @endphp
            <x-form.select label="{{ trans('article.active') }}" name="active"
                           :options="$options" :target-model="$question"
            />

            <div class="mt-5">
                <div class="shadow card">
                    <div class="text-white card-header bg-dark d-flex justify-content-start">
                        @lang('admin.answers')
                    </div>
                    <div class="card-body">

                        <div class="border rounded p-2 mb-3">
                            <input class="form-check-input h4" type="radio" id="true-or-false" name="question_type"
                                   value="true-or-false" @checked($question->type == 'true-or-false')>
                            <label class="form-check-label h4 mb-3" for="html">True or False</label>
                            <div id="true-or-false" class="mx-3">
                                <input class="form-check-input h5" type="radio" id="true" name="correct_answer"
                                       value="true" @checked(($question->answers->count() > 0) && ($question->answers[0]->correct == 1))>
                                <label class="form-check-label h5" for="html">True</label><br>
                                <input class="form-check-input h5" type="radio" id="false" name="correct_answer"
                                       value="false" @checked(($question->answers->count() > 1) && ($question->answers[1]->correct == 1))>
                                <label class="form-check-label h5" for="css">False</label>
                            </div>
                        </div>

                        <div class="border rounded p-2 ">
                            <input class="form-check-input h4" type="radio" id="multiple-choices" name="question_type"
                                   value="multiple-choices" @checked($question->type == 'multiple-choices')>
                            <label class="form-check-label h4 mb-3" for="css">Multiple Choices</label>
                            <div id="multiple-choices">
                                @if($question->type == 'multiple-choices')
                                    <livewire:add-answer :storedAnswers="$question->answers"/>
                                @else
                                    <livewire:add-answer/>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <div class="d-flex mt-3">
                <x-form.submit-button title="{{ trans('article.publish') }}" class="btn-success"/>
            </div>

        </form>

    </x-form.main>

@endsection

