<div>

    <div class="mx-auto" style="max-width: 850px">
        <div class="d-flex justify-content-between mb-3 px-3 py-3 bg-info text-white fw-bold rounded mt-1">

            <div>
                @lang('admin.question') <span>{{ $currentQuestion+1 }}</span> /{{ $questions->count() }}
            </div>

            <div wire:ignore class="fw-bold">@lang('admin.time_remaining'):
                <span id="timer">
                    <span id="minutes">00</span>:<span id="seconds">00</span>
                </span>
            </div>

        </div>
        <div class="container desktop-margin">

            <div>
                <div>
                    <div class="row justify-content-center align-items-center">
                        <h5>{!! $question->translate()->content !!}</h5>

                        <div class="col-md-6">

                            <div class="text-center">
                                <img class="img-fluid shadow"
                                     alt="IQ Test. Question {{ $currentQuestion+1 }}"
                                     title="IQ Test. Question {{ $currentQuestion+1 }}"
                                     src="{{ $question->image() }}">
                            </div>

                        </div>

                        <div class="col-md-6 my-2">

                            <div class="row justify-content-center align-items-center">
                                @foreach($question->answers as $answer)

                                    <div
                                        class="col-4 text-center p-1 mb-2 {{ ($selectedAnswers[$question->id] ?? '') === $answer->id ? 'highlight-answer' : '' }}"
                                        wire:click.prevent="selectAnswer({{$answer->id}})"
                                        style="cursor: pointer;"
                                    >
                                        <p class="text-center m-0 fw-bold">{{ $optionLetter++ }}</p>
                                        <img width="100" height="100"
                                             class="img-fluid"
                                             alt="IQ Test. Question {{ $currentQuestion+1 }}, option {{ $optionLetter }}"
                                             title="option {{ $optionLetter }}, {{ $answer->translate()?->content }}"
                                             src="{{ $answer->image() }}">
                                        <br>

                                    </div>
                                @endforeach
                            </div>

                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mt-2 desktop-margin">
                            <div class="">
                                <button type="button" class="btn btn-info btn-sm"
                                        wire:click.prevent="prevoiusQuestion()">
                                    <span
                                        class="d-inline-block"
                                        {{ app()->getLocale() === 'ar' ? 'style=transform:rotate(180deg);' : '' }}
                                    >&#8592; </span>
                                    <span>@lang('admin.prevoius_question')</span>
                                </button>
                            </div>

                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#backToHome">
                                @lang('admin.exit')
                            </button>

                            <div class="">
                                @if ($currentQuestion === (count($questions) -1) )
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#finishTheTest" wire:click="">
                                        @lang('admin.go_to_result')
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-info"
                                            wire:click="nextQuestion()">
                                        @lang('admin.next_question') <span
                                            class="d-inline-block"
                                        {{ app()->getLocale() === 'ar' ? 'style=transform:rotate(180deg);' : '' }}
                                        > &#8594;</span>
                                    </button>
                                @endif

                            </div>
                        </div>
                        <div class="row col-lg-10 mx-auto p-0 mt-3 desktop-margin">
                            @foreach($questions as $index => $question)
                                @if (($index+1) % 10 == 1)
                                    <div class="col-0"></div>
                                @endif
                                <div class="col-3 col-md-2 col-lg-1 px-1 mb-1">
                                    <a href="#" wire:click.prevent="goToQuestion({{ $index }})"
                                       class="border rounded px-1 d-block text-center {{ $index === $currentQuestion ? 'bg-info text-white' : '' }}"
                                    >{{ $index + 1 }}@if(isset($selectedAnswers[$question->id]))
                                            <span class="fw-bold">&#10003;</span>
                                        @endif</a>
                                </div>

                                @if (($index+1) % 10 == 0)
                                    <div class="col-0"></div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Finish the test Modal -->
    <div class="modal fade" id="finishTheTest" tabindex="-1" aria-labelledby="finishTheTestLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="finishTheTestLabel">@lang('admin.you_smart')</h5>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (count($this->questions) === count($this->selectedAnswers))
                        @lang('admin.all_answered')
                    @else
                        @lang('admin.not_all_answered')
                    @endif

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        @lang('admin.resume_the_test')
                    </button>
                    <button class="btn btn-success"
                            wire:click.prevent="submit(timeLeftInSeconds)">@lang('admin.go_to_result')</button>
                </div>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        const timerDisplay = document.querySelector('#timer');
        let timeLeftInSeconds = {{ $timer }};

        function startTimer() {
            setInterval(() => {
                const minutes = Math.floor(timeLeftInSeconds / 60);
                let seconds = timeLeftInSeconds % 60;

                if (seconds < 10) {
                    seconds = "0" + seconds;
                }

                timerDisplay.innerHTML = `<span id="minutes">${minutes}</span>:<span id="seconds">${seconds}</span>`;
                if (timeLeftInSeconds > 0) {
                    timeLeftInSeconds--;
                }

                if (timeLeftInSeconds === 0) {
                    Livewire.emit('timerExpired', timeLeftInSeconds);
                }
            }, 1000);
        }

        window.onload = function () {
            startTimer();
        }

    </script>

@endsection
