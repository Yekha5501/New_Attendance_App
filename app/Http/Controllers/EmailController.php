<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Scan;
use App\Models\Student;
use App\Models\Worship;
use App\Models\WorshipSession;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use PDF;

use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;


use PhpOffice\PhpSpreadsheet\IOFactory;

class EmailController extends Controller
{
    public function sendEmail()
    {
        Mail::to('bece19-pmandindi@mubas.ac.mw')->send(new TestEmail());
        return redirect()->route('attendance')->with('success', 'Email has been sent.');
    }

    public function viewResults()
    {
        return view('view-results');
    }

    public function uploadAttendance(Request $request)
    {
        $request->validate([
            'attendance_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('attendance_file');
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $latestSession = WorshipSession::orderBy('created_at', 'desc')->first();

        if (!$latestSession) {
            return back()->with('Error', 'no worship session found.');
        }
        if ($latestSession->status !== 'Completed') {
            return back()->with('error', 'Please set the worship sesion to compleeted status');
        }

        $attendanceRecords = [];
        foreach ($rows as $index => $row) {
            if ($index === 0) continue;
            $registrationNumber = trim($row[0]);

            $student = Student::where('registration_number', $registrationNumber)->first();
            if (!$student) continue;

            $existingAttendance = Worship::where('worship_session_id', $latestSession->id)
                ->where('$student_id', $student->id)
                ->exists();

            if (!$existingAttendance) {
                $attendanceRecords[] = [
                    'worship_session_id' => $latestSession->id,
                    'student_id' => $student->id,
                    'attendance' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if (!empty($attendanceRecords)) {
                    Worship::insert($attendanceRecords);
                }

                return redirect()->route('attendnce.upload.form')
                    ->with('success', 'Attendance Marked successfully');
            }
        }
    }

    public function generateQRCodes()
    {
        $students = Student::all();

        foreach ($students as $student) {
            $qrCode = QRCode::size(200)->generate($student->registration_number);
            $fileName = 'qr_code_' . $student->registration_number . 'svg';
            $path = 'public/qr_codes/' . $fileName;

            Storage::put($path, $qrCode);

            $student->qrcode_path = $path;
            $student->save();
        }

        return redirect()->back()->with('success', 'QR Codes generated successfully');
    }

    public function store(Request $request)
    {

        try {
            $sessionInProgress = WorshipSession::where('status', 'Progress')->exists();

            if ($sessionInProgress) {
                return redirect()->back()->with('error', 'cannot create a new session while another session is in progress');
            }

            $validatedData = $request->validate([
                'title' => 'required|string',
                'date' => 'required|date',
                'type' => 'required|in:Morning,Evening',

            ]);

            // Generate a random worship session ID starting with "MAU"
            $worshipSessionId = 'MAU' . rand(1000, 9999);

            // Get local time stamp for the new worship session

            $localTimeStamp = now()->timeZone('Africa/Nairobi');

            // create a new worship session

            $worshipSession = new WorshipSession();

            $worshipSession->worship_session_id = $worshipSessionId;
            $worshipSession->title = $validatedData['title'];
            $worshipSession->date = $validatedData['date'];
            $worshipSession->type = $validatedData['type'];
            $worshipSession->status = 'progress';
            $worshipSession->time_created = $localTimeStamp;
            $worshipSession->save();

            return redirect()->back()->with('sucess', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function showAttendance(Request $request)
    {

        $searchQuery = $request->input('search', '');

        $totalSession = WorshipSession::count();

        $students = Student::where('name', 'like', '%' . $searchQuery . '%')
            ->orWhere('registration_number', 'like', '%' . $searchQuery . '%')
            ->orWhere('program_of_study', 'like', '%' . $searchQuery . '%')
            ->paginate(10)
            ->appends(['search' => $searchQuery]);

        foreach ($students as $student) {
        }
    }


    public function finalReport()
    {

        $students = Student::all();
        $worshipSessions = WorshipSession::all();

        $data = $students->map(function ($tudent) use ($worshipSessions) {
            $attendance = $worshipSessions->mapWithKeys(function ($session) use ($student) {
                $worship = Worship::where('student_id', $student->id)
                    ->where('worship_session_id', $session->id)
                    ->first();
                return [$session->$worship ? 1 : 0];

                return [
                    'first_name' => $student->First_name,
                    'surname' => $student->Surname,
                    'registration_number' => $student->registration_number,
                    'average_grade' => $student->avg_grade,

                ];
            });

            $pdf = PDF::loadView('student.pdf', compact('data', 'worshipSessions'));
            return $pdf->download('student.pdf');
        });
    }

    public function downloadExcell(Request $request)
    {
        $program = $request->input('program');
        $exporter = new studentExportByProgram($program);
        return $exporter->export();
    }


    public function storeAttendance(Request $request, $worshipSessionId)
    {
        foreach ($request->attendance as $studentId => $attndanceVaue) {
            $attendance = Worship::where('studentId', $studentId)
                ->where('worshipSessionId', $worshipSessionId)
                ->first();

                if ($attendance) {
                    continue;
                }

                Worship::create([
                    'studentId' => $studentId,
                    'attendance' => $attendance,
                    'worshipSessionId' => $worshipSessionId,

                ]);
        }

        return redirect()->route('worshipSession.show', $worshipSessionId)
        ->with('success', 'Attendance has been successfully added.');
    }

    public
}
