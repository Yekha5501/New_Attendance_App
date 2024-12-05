<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WorshipSession;
use App\Models\Worship;
use App\Models\Student;

class AttendancePercentage extends Component
{
    public $attendancePercentage;
    public $attendedStudents;  // Declare the variable

    public function mount()
    {
        $this->calculateAttendancePercentage();
    }

    public function calculateAttendancePercentage()
    {
        // Get the latest worship session
        $latestSession = WorshipSession::latest()->first();

        if ($latestSession) {
            // Calculate total students
            $totalStudents = Student::count();

            // Calculate attended students
            $this->attendedStudents = Worship::where('worship_session_id', $latestSession->id)
                                             ->where('attendance', 1)
                                             ->count();

            // Calculate the attendance percentage
            $this->attendancePercentage = $totalStudents > 0 ? round(($this->attendedStudents / $totalStudents) * 100) : 0;
        } else {
            $this->attendancePercentage = 0;
            $this->attendedStudents = 0;  // Set to 0 if no session exists
        }
    }

    public function render()
    {
        return view('livewire.attendance-percentage');
    }
}
