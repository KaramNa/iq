<?php

namespace App\Http\Livewire;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Test;
use Livewire\Component;

class TakeTest extends Component
{

    public $questions;
    public $optionLetter = 'A';
    public $currentQuestion = 0;
    public $selectedAnswers = [];
    public $progress = 0;
    public $timer = 20;
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
        return view('livewire.take-test')->layout('layouts.take-test');
    }

    public function mount()
    {
        session()->regenerate();
        session()->put('name', strtoupper(request()->test_taker_name));
        $this->test = Test::whereTranslation('slug', request()->slug)->firstOrFail();
        $this->questions = Question::where('test_id', $this->test->id)->inRandomOrder()->get();
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

    public function submit()
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
        $userAverage = 22;
        $standardDeviation = 6.03;
        $zi = ($totalPoints - $userAverage) / $standardDeviation;
        $finalScore = intval(100 + ($zi * 15));
        session()->put('score', $finalScore);
        return redirect()->route('test.prepare.result', ['slug' => $this->test->translate()->slug]);
    }

    public function goToQuestion($questionNumber)
    {
        $this->currentQuestion = $questionNumber;
    }

}
