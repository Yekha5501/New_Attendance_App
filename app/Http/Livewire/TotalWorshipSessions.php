<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WorshipSession;

class TotalWorshipSessions extends Component
{
    public $totalSessions;

    public function mount()
    {
        $this->fetchTotalSessions();
    }

    public function fetchTotalSessions()
    {
        $this->totalSessions = WorshipSession::count();
    }

    public function render()
    {
        return view('livewire.total-worship-sessions');
    }
}
