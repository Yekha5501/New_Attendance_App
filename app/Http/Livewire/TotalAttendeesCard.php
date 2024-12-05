<?php


// app/Http/Livewire/TotalAttendeesCard.php
namespace App\Http\Livewire;

use Livewire\Component;

class TotalAttendeesCard extends Component
{
    public $totalAttendees = 4567;

    public function render()
    {
        return view('livewire.total-attendees-card', ['totalAttendees' => $this->totalAttendees]);
    }
}
