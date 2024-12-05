<?php

// app/Http/Livewire/AnotherCard.php
namespace App\Http\Livewire;

use Livewire\Component;

class AnotherCard extends Component
{
    public $description = "Description of the card";

    public function render()
    {
        return view('livewire.another-card', ['description' => $this->description]);
    }
}

