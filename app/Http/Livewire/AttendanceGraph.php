<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\WorshipSession;
use App\Models\Worship;

class AttendanceGraph extends Component
{
public $morningAttendance = [];
public $eveningAttendance = [];
public $categories = [];
public $maxAttendance = 0;

public function mount()
{
$this->fetchAttendanceData();
}

public function fetchAttendanceData()
{
// Get the last 14 worship sessions grouped by date
$sessions = WorshipSession::orderBy('date', 'desc')->take(14)->get()->groupBy('date');

$morningAttendance = [];
$eveningAttendance = [];
$categories = [];

foreach ($sessions as $date => $sessionGroup) {
$categories[] = $date;

$morningCount = 0;
$eveningCount = 0;

foreach ($sessionGroup as $session) {
if ($session->type === 'Morning') {
$morningCount = Worship::where('worship_session_id', $session->id)->count();
} elseif ($session->type === 'Evening') {
$eveningCount = Worship::where('worship_session_id', $session->id)->count();
}
}

$morningAttendance[] = $morningCount;
$eveningAttendance[] = $eveningCount;

$this->maxAttendance = max($this->maxAttendance, $morningCount, $eveningCount);
}

$this->morningAttendance = $morningAttendance;
$this->eveningAttendance = $eveningAttendance;
$this->categories = $categories;
}

public function render()
{
return view('livewire.attendance-graph');
}
}
