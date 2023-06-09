<?php

namespace App\Http\Livewire;

use App\Helpers\UserSystemInfoHelper;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use App\Models\TestResult;
use Livewire\Component;
use Stevebauman\Location\Facades\Location;

class TakeTest extends Component
{

    public $questions;
    public $optionLetter = 'A';
    public $currentQuestion = 0;
    public $selectedAnswers = [];
    public $progress = 0;
    public $timer = 1200;
    public $totalQuestions = 0;
    public $question;
    public $imagesLoaded = false;
    public $test;

    protected $listeners = ['timerExpired' => 'submit'];

    public function updatedImagesLoaded()
    {
        if ($this->imagesLoaded) {
            $this->emit('$set', '.blur-container', 'class', '');
        }
    }

    public function render()
    {
        $this->progress = ($this->currentQuestion + 1) / ($this->questions->count()) * 100;
        $this->question = $this->questions[$this->currentQuestion] ?? null;
        $this->totalQuestions = count($this->questions);
        return view('livewire.take-test')->layout('layouts.take-test',[
            'test' => $this->test
        ]);
    }

    public function mount()
    {
        session()->regenerate();
        session()->put('name', strtoupper(request()->test_taker_name));
        session()->put('age', strtoupper(request()->test_taker_age));
        $this->test = Test::whereTranslation('slug', request()->slug)->firstOrFail();
        $this->questions = Question::where('test_id', $this->test->id)->inRandomOrder()->limit($this->test->num_of_questions)->get();
        $this->timer = $this->test->duration * 60;
    }

    public function selectAnswer($optionId)
    {
        $this->selectedAnswers[$this->question->id] = $optionId;
        if ($this->currentQuestion < count($this->questions) - 1) {
            $this->currentQuestion++;
        }
    }

    public function nextQuestion()
    {
        if ($this->currentQuestion < count($this->questions) - 1) {
            $this->currentQuestion++;
        }
    }

    public function prevoiusQuestion()
    {
        if ($this->currentQuestion > 0) {
            $this->currentQuestion--;
        }
    }

    public function submit($timeLeftInSeconds)
    {
        $totalPoints = 0;
        foreach ($this->questions as $question) {
            if (isset($this->selectedAnswers[$question->id])) {
                $answer = Answer::where('question_id', $question->id)->where('correct', 1)->first();
                if (($this->selectedAnswers[$question->id] ?? '') === $answer->id) {
                    $totalPoints += $answer->weight;
                }
            }
        }

        $this->test->level === 0 ? $userAverage = 30 : ($this->test->level === 1 ? $userAverage = 25 : $userAverage = 17);
        $standardDeviation = 6.03;
        $zi = ($totalPoints - $userAverage) / $standardDeviation;
        $finalScore = intval(100 + ($zi * 15));
        session()->put('score', $finalScore);
        $country = (new UserSystemInfoHelper)->get_country_from_ip(request()->ip())['country'];
        TestResult::create([
            'test_id' => $this->test->id,
            'test_taker_name' => session('name'),
            'test_taker_age' => session('age'),
            'test_taker_country' => $country,
            'score' => $finalScore,
            'test_completion_time' => $this->timer - $timeLeftInSeconds
        ]);
        return redirect()->route('test.prepare.result', ['slug' => $this->test->translate()->slug]);
    }

    public function goToQuestion($questionNumber)
    {
        $this->currentQuestion = $questionNumber;
    }

}
