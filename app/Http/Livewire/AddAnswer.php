<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class AddAnswer extends Component
{
    use WithFileUploads;

    public $answer;
    public $answerCount = 0;
    public $answerInputs = [];
    public $storedAnswers = null;
    public $answer_content, $answer_image;

    protected $listeners = ['removeAnswer' => 'removeAnswer'];

    public function mount()
    {
        if ($this->storedAnswers) {
            $this->answerCount = count($this->storedAnswers) - 1;
            for ($i = 0; $i <= $this->answerCount; $i++) {
                $this->answerInputs[] = $i;
            }
        }
    }

    public function render()
    {
        return view('livewire.add-answer');
    }

    public function addAnswer()
    {
        array_push($this->answerInputs, $this->answerCount++);
    }

    public function removeAnswer($key)
    {
        unset($this->answerInputs[$key]);
        unset($this->answer_content[$key]);
        unset($this->answer_image[$key]);
        unset($this->storedAnswers[$key]);
        $this->answerCount = count($this->answerInputs);
    }
}
