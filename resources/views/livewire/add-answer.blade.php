<div>
    <div class="d-flex align-items-center justify-content-between w-100">
        <button id="add_new_Answer" class="text-white btn bg-dark mb-3" type="button"
                wire:click.prevent="addAnswer">
            <i class="fas fa-plus"></i>
        </button>
    </div>
    <input type="hidden" name="answers[number_of_answers]"
           id="answers[number_of_answers]"
           value="{{ $answerCount }}">
    @foreach ($answerInputs as $key => $value)

        <div class="col-lg-12 mb-3">
            <div id="accordion-{{ $key }}" class="accordion-wrapper d-flex justify-content-between">

                <div class="card accordion-item col-11">
                    <div class="card-header" id="accordion-heading-{{ $key }}">
                        <button
                            class="collapsed w-100 border-0 bg-transparent d-flex justify-content-between align-items-center"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#accordion-collapse-{{ $key }}"
                            aria-expanded="false"
                            aria-controls="accordion-collapse-{{ $key }}"
                        >
                            <span>@lang('admin.option') {{ $key+1 }}</span>
                            <span class="fal fa-check-circle text-success fw-bold"></span>
                        </button>

                    </div>

                    <div id="accordion-collapse-{{ $key }}" class="collapse"
                         aria-labelledby="accordion-heading-{{ $key }}" data-bs-target="#accordion-{{ $key }}">
                        <div class="card-body">
                            <div>
                                <x-form.languages-tabs :key="'-'.$key"/>

                                <div class="tab-content" id="pills-tabContent.{{ $key }}">
                                    @foreach(LaravelLocalization::getSupportedLocales() as $code => $lang)
                                        <x-form.languages-tabs-contents :key="$code" :code="'-'.$key">

                                            <x-form.input-label name="content.{{$key}}"
                                                                :label="trans('article.content')" :key="$code">

                                                <textarea
                                                    id="answers[{{ $code }}.content.{{$key}}]"
                                                    name="answers[{{ $code }}.content.{{$key}}]"
                                                    rows="5"
                                                    style="direction: {{ $code == 'ar' ? 'rtl' : 'ltr' }}"
                                                    class="form-control char-counts"
                                                >{{old($code . '.content.' . $key,  isset($storedAnswers[$loop->parent->index]) ? $storedAnswers[$loop->parent->index]->translate($code)?->content : '')}}</textarea>

                                            </x-form.input-label>

                                        </x-form.languages-tabs-contents>

                                    @endforeach
                                </div>

                            </div>

                            <input type="hidden" name="answers[temp_file_selector.{{ $key }}]"
                                   id="answers[temp_file_selector.{{ $key }}]"
                                   value="{{uniqid()}}">

                            <input type="hidden" name="answers[answer_id.{{ $key }}]" id="answers[answer_id.{{ $key }}]"
                                   value="{{isset($storedAnswers[$loop->index]) ? $storedAnswers[$loop->index]->id : ''}}">

                            <x-form.text-input
                                :label="trans('article.image')"
                                name="answers[answer_image.{{ $key }}]"
                                type="file"
                                accept="image/*"
                                :target-model="$storedAnswers[$loop->index] ?? ''"
                            />

                            <x-form.text-input
                                :label="trans('admin.weight')"
                                name="answers[weight.{{ $key }}]"
                                type="number"
                                step="0.01"
                                :target-model="$storedAnswers[$loop->index]->weight ?? ''"
                            />

                            <x-form.radio-input name="answers[correct.{{ $key }}]" label="correct"
                                                id="answers[correct.{{ $key }}]"
                                                value="1"
                                                :target-model="isset($storedAnswers[$loop->index]) ? $storedAnswers[$loop->index]->correct : ''"/>
                        </div>
                    </div>
                </div>
                <button
                    type="button"
                    class="btn btn-danger h-25"
                    onclick='let result = confirm("{{ trans('admin.delete_confirmation') }}");if (result) {Livewire.emit("removeAnswer", {{$key}});}'
                >
                    <i class="fal fa-minus fw-bold"></i>
                </button>
            </div>

        </div>

    @endforeach
</div>
