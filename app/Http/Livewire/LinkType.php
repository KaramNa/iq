<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LinkType extends Component
{
    public function render()
    {
        return view('livewire.link-type');
    }

    public function updatedType($type)
    {
        dd($type);
    }
}
