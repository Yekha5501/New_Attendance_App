<?php
// app/Http/Livewire/TotalStudentsCard.php


// app/Http/Livewire/TotalStudentsCard.php
// app/Http/Livewire/TotalStudentsCard.php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;

class TotalStudentsCard extends Component
{
    public $totalStudents;

    public function mount()
    {
        $this->totalStudents = Student::count();
    }

    public function render()
    {
        return view('livewire.total-students-card');
    }
}
