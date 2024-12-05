<?php

namespace App\Http\Controllers;

use App\Exports\StudentsExportbyProgram;
use App\Exports\StudentsExport;
use App\Exports\StudentsExportbyProgramMonthly;
use App\Models\Worship;
use App\Models\Student;
use App\Models\WorshipSession;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExportPhpSpreadsheet;
use PDF;
use Illuminate\Support\Facades\DB;


class WorshipSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function report()
    {
        // Fetch unique programs from the students table
        $programs = Student::select('program_of_study')->distinct()->pluck('program_of_study');

        // Fetch unique months from the scans table
        $months = DB::table('scans')
            ->select(DB::raw("DISTINCT DATE_FORMAT(created_at, '%Y-%m') as month_year"))
            ->orderBy('month_year', 'desc')
            ->get();

        return view('report', compact('programs', 'months'));
    }


    public function exportToExcel()
    {
        $export = new StudentsExportPhpSpreadsheet();
        return $export->export();
    }

    public function downloadExcel(Request $request)
    {
        $program = $request->input('program');

        $exporter = new StudentsExportbyProgram($program);
        return $exporter->export();
    }

    public function downloadExcelWithMonth(Request $request)
    {
        $program = $request->input('program');
        $monthYear = $request->input('month_year');

        $exporter = new StudentsExportbyProgramMonthly($program, $monthYear); // Pass monthYear to the exporter
        return $exporter->export();
    }



    public function export()
    {
        $exporter = new StudentsExport();
        return $exporter->export();
    }


    public function show()
    {
        // Fetch all worship sessions and order them by status ('Progress' first)
        $worshipSessions = WorshipSession::orderByRaw("FIELD(status, 'Progress', 'Completed')")->get();

        // Fetch attendance records for each worship session
        foreach ($worshipSessions as $worshipSession) {
            $worshipSession->attendanceRecords = Worship::where('worship_session_id', $worshipSession->id)->get();
        }

        return view('worship-sessions.show', ['worshipSessions' => $worshipSessions]);
    }
   public function showManualAttendanceForm($id)
{
    $worshipSession = WorshipSession::findOrFail($id);

    // Retrieve all students and their attendance status for the worship session
    $students = Student::all()->map(function($student) use ($id) {
        $student->attended = Worship::where('worship_session_id', $id)
            ->where('student_id', $student->id)
            ->where('attendance', 1)
            ->exists();
        return $student;
    });

    return view('worship-sessions.manual-attendance', compact('worshipSession', 'students'));
}

public function storreAttendance(Request $request, $worshipSessionId)
{
    // Loop through each student attendance data from the form
    foreach ($request->attendance as $studentId => $attendanceValue) {
        // Find the existing attendance record for the given student and worship session
        $attendance = Worship::where('student_id', $studentId)
                             ->where('worship_session_id', $worshipSessionId)
                             ->first();

        // If the attendance record exists, update it
        if ($attendance) {
            $attendance->attendance = $attendanceValue;
            $attendance->save();
        }
        // If the attendance record does not exist, create a new one
        else {
            Worship::create([
                'student_id' => $studentId,
                'attendance' => $attendanceValue,
                'worship_session_id' => $worshipSessionId,
            ]);
        }
    }

    // Return back with success message
    return redirect()->route('worship-sessions.show', $worshipSessionId)
                     ->with('success', 'Attendance has been successfully updated.');
}

public function storeAttendance(Request $request, $worshipSessionId)
{
    // Loop through each student attendance data from the form
    foreach ($request->attendance as $studentId => $attendanceValue) {
        // Check if an attendance record already exists for the student and worship session
        $attendance = Worship::where('student_id', $studentId)
                             ->where('worship_session_id', $worshipSessionId)
                             ->first();

        // If attendance record exists, skip creating/updating
        if ($attendance) {
            continue; // Skip to the next student
        }

        // If no record exists, create a new attendance record
        Worship::create([
            'student_id' => $studentId,
            'attendance' => $attendanceValue,
            'worship_session_id' => $worshipSessionId,
        ]);
    }

    // Return back with success message
    return redirect()->route('worship-sessions.show', $worshipSessionId)
                     ->with('success', 'Attendance has been successfully updated.');
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('worship-sessions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Check if there is any session in progress
            $sessionInProgress = WorshipSession::where('status', 'Progress')->exists();

            if ($sessionInProgress) {
                return redirect()->back()->with('error', 'Cannot create a new session while there is one in progress.');
            }

            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string',
                'date' => 'required|date',
                'type' => 'required|in:Morning,Evening',
            ]);

            // Generate a random worship session ID starting with "MAU"
            $worshipSessionId = 'MAU' . rand(1000, 9999); // Example: MAU1234

            // Create a new worship session
            $worshipSession = new WorshipSession();
            $worshipSession->worship_session_id = $worshipSessionId;
            $worshipSession->title = $validatedData['title'];
            $worshipSession->date = $validatedData['date'];
            $worshipSession->type = $validatedData['type'];
            $worshipSession->status = 'Progress'; // Set status to Progress
            $worshipSession->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Worship session created successfully');
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error creating worship session: ' . $e->getMessage());

            // Redirect back with an error message
            \Session::put('error', 'Cannot create a new session while there is one in progress.');
            return redirect()->back();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function markSession($id)
    {
        $worshipSession = WorshipSession::findOrFail($id);
        $worshipSession->status = 'Completed';
        $worshipSession->save();

        return redirect()->back()->with('success', 'Worship session marked as completed.');
    }

    public function setProgress($id)
    {
        $worshipSession = WorshipSession::findOrFail($id);
        $worshipSession->status = 'Progress';
        $worshipSession->save();

        return redirect()->back()->with('success', 'Worship session set back to Progress.');
    }

    public function finalReport()
    {
        // Fetch all students
        $students = Student::all();

        // Fetch all worship sessions with their dates
        $worshipSessions = WorshipSession::select('id', 'date')->get();

        // Create an array to store attendance records
        $attendanceRecords = [];

        foreach ($students as $student) {
            // Initialize attendance array with 0 for each worship date
            $attendance = array_fill_keys($worshipSessions->pluck('date')->toArray(), 0);

            // Fetch attendance records for the student
            $studentAttendances = Worship::where('student_id', $student->id)->get();

            foreach ($studentAttendances as $record) {
                // Mark attendance as 1 for the specific date
                $sessionDate = $worshipSessions->firstWhere('id', $record->worship_session_id)->date;
                $attendance[$sessionDate] = 1;
            }

            // Add the student and their attendance record to the array
            $attendanceRecords[] = [
                'student' => $student,
                'attendance' => $attendance,
            ];
        }

        return view('reports.final', compact('attendanceRecords', 'worshipSessions'));
    }



    public function PdfReport()
    {
        $students = Student::all();
        $worshipSessions = WorshipSession::all();

        $data = $students->map(function ($student) use ($worshipSessions) {
            $attendance = $worshipSessions->mapWithKeys(function ($session) use ($student) {
                $worship = Worship::where('student_id', $student->id)
                    ->where('worship_session_id', $session->id)
                    ->first();
                return [$session->id => $worship ? 1 : 0];
            });

            return [
                'first_name' => $student->First_name,
                'surname' => $student->Surname,
                'registration_number' => $student->registration_number,
                'attendance' => $attendance,
                'average_grade' => $student->avg_grade,
            ];
        });

        $pdf = PDF::loadView('student.pdf', compact('data', 'worshipSessions'));
        return $pdf->download('students.pdf');
    }
}
