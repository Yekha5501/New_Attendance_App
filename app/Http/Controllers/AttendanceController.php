<?php

namespace App\Http\Controllers;

use App\Models\Scan;
use App\Models\Student;
use App\Models\Worship;
use App\Models\WorshipSession;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use PDF;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Exception as PhpSpreadsheetException;



class AttendanceController extends Controller


{

public function showManualAttendanceForm()
{
    $worshipSessions = WorshipSession::whereDate('date', today())
        ->where('status', 'Progress')
        ->get();

    return view('attendance.manual', compact('worshipSessions'));
}

public function markManualAttendance(Request $request)
{
    $request->validate([
        'registration_number' => 'required|string',
        'worship_session_id' => 'required|exists:worship_sessions,id',
    ]);

    $student = Student::where('registration_number', $request->registration_number)->first();
    if (!$student) {
        return redirect()->back()->withErrors(['Student not found']);
    }

    $existingAttendance = Worship::where('student_id', $student->id)
        ->where('worship_session_id', $request->worship_session_id)
        ->first();

    if ($existingAttendance) {
        return redirect()->back()->withErrors(['Already marked attendance for this session']);
    }

    Worship::create([
        'student_id' => $student->id,
        'attendance' => 1,
        'worship_session_id' => $request->worship_session_id,
    ]);

    return redirect()->route('attendance.manual')->with('success', 'Attendance marked successfully');
}

public function showAttendance()
{
    // Paginate the students
    $students = Student::paginate(6);

    // Retrieve the total number of worship sessions once
    $totalSessions = WorshipSession::count();

    foreach ($students as $student) {
        // Retrieve the total number of worship sessions attended by the student
        $attendedSessions = Worship::where('student_id', $student->id)->count();

        // Calculate the attendance percentage
        $attendancePercentage = $totalSessions > 0 ? ($attendedSessions / $totalSessions) * 100 : 0;

        // Round the attendance percentage to the nearest whole number
        $attendancePercentage = round($attendancePercentage);

        // Update the student's avg_grade with the attendance percentage
        $student->avg_grade = $attendancePercentage;
        $student->save();
    }

    // Return the view with the paginated students
    return view('student.attendance', ['students' => $students]);
}






    public function calculateAttendancePercentage()
    {
        // Retrieve all students
        $students = Student::all();

        foreach ($students as $student) {
            // Retrieve the total number of worship sessions
            $totalSessions = WorshipSession::count();

            // Retrieve the total number of worship sessions attended by the student
            $attendedSessions = Worship::where('student_id', $student->id)->count();

            // Calculate the attendance percentage
            $attendancePercentage = ($attendedSessions / $totalSessions) * 100;

            // Update the student's record with the attendance percentage
            $student->attendance_percentage = $attendancePercentage;
            $student->save();
        }

        return redirect()->route('attendance.percentages')->with('success', 'Attendance percentages calculated successfully');
    }

    public function generrateQRCodes()
    {
        $students = Student::all();

        foreach ($students as $student) {
            // Include student's name in QR code data
            $qrCodeData = [
                'id' => $student->id,
                'name' => $student->name,
            ];

            $qrCode = QrCode::size(300)->generate(json_encode($qrCodeData));
            $fileName = 'qr_code_' . $student->id . '.svg';
            $path = 'public/qr_codes/' . $fileName;

            // Save the QR code image to storage
            Storage::put($path, $qrCode);

            // Store the path in the database
            $student->qrcode_path = $path;
            $student->save();
        }

        return redirect()->back()->with('success', 'QR codes generated successfully');
    }



    public function gennerateQRCodes()
    {
        $students = Student::all();

        foreach ($students as $student) {
            $qrCode = QrCode::size(300)->generate($student->id);
            $fileName = 'qr_code_' . $student->id . '.svg';
            $path = 'public/qr_codes/' . $fileName;

            // Save the QR code image to storage
            Storage::put($path, $qrCode);

            // Store the path in the database
            $student->qrcode_path = $path;
            $student->save();
        }

        return redirect()->back()->with('success', 'QR codes generated successfully');
    }
    public function generateQRCodes()
    {
        $students = Student::all();

        foreach ($students as $student) {
            $qrCode = QrCode::size(300)->generate($student->registration_number);
            $fileName = 'qr_code_' . $student->registration_number . '.svg';
            $path = 'public/qr_codes/' . $fileName;

            // Save the QR code image to storage
            Storage::put($path, $qrCode);

            // Store the path in the database
            $student->qrcode_path = $path;
            $student->save();
        }

        return redirect()->back()->with('success', 'QR codes generated successfully');
    }

    public function viewQRCode(Student $student)
    {
        return view('student.qrcode', compact('student'));
    }

public function viewAllQRCode(Request $request)
{
    // Get the search query from the request
    $searchQuery = $request->input('search', '');

    // Paginate the students, 4 per page, and filter by name or program
    $students = Student::where('name', 'like', '%' . $searchQuery . '%')
                        ->orWhere('program_of_study', 'like', '%' . $searchQuery . '%')
                        ->paginate(4)
                        ->appends(['search' => $searchQuery]); // Preserve the search query in pagination links

    return view('student.all_qrcodes', compact('students'));
}





public function scanAttendance(Request $request)
{
    $qrCodeData = $request->input('qrCodeData');

    // Check if $qrCodeData is provided and is a string
    if (empty($qrCodeData) || !is_string($qrCodeData)) {
        return response()->json(['message' => 'Invalid QR code data'], 400);
    }

    // Retrieve the student details by registration_number
    $student = Student::where('registration_number', $qrCodeData)->first();

    if (!$student) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    // Retrieve the latest worship session
    $latestWorshipSession = WorshipSession::latest()->first();

    // Check if a worship session exists
    if (!$latestWorshipSession) {
        return response()->json(['message' => 'No worship session found'], 400);
    }

    // Check if the latest worship session is completed
    if ($latestWorshipSession->status == 'Completed') {
        return response()->json(['message' => 'Worship session is closed'], 400);
    }

    // Retrieve the worship session ID
    $latestWorshipSessionId = $latestWorshipSession->id;

    // Check if the student has already been scanned for this worship session
    $existingAttendance = Worship::where('student_id', $student->id)
        ->where('worship_session_id', $latestWorshipSessionId)
        ->first();

    if ($existingAttendance) {
        // Student has already been scanned for this worship session
        return response()->json(['message' => 'Already scanned for this worship session'], 400);
    }

    // Insert a new record in the worship table
    $attendance = Worship::create([
        'student_id' => $student->id,
        'attendance' => 1,
        'worship_session_id' => $latestWorshipSessionId,
    ]);

    // Insert a new record in the scans table
    $scan = Scan::create([
        'user_id' => auth()->id(), // Assuming the user is authenticated
        'worship_session_id' => $latestWorshipSessionId,
        'student_id' => $student->id,
    ]);

    // Return the student details along with the response
    return response()->json([
        'message' => 'Attendance marked successfully',
        'worship_session_id' => $attendance->worship_session_id,
        'student' => [
            
            'name' => $student->name,
           
        ],
    ]);
}






   public function scannAttendance(Request $request)
{
    $qrCodeData = $request->input('qrCodeData');

    // Check if $qrCodeData is an array and contains the 'student_id' key
    if (!is_array($qrCodeData) || !array_key_exists('student_id', $qrCodeData)) {
        return response()->json(['message' => 'Invalid QR code data'], 400);
    }

    // Assuming QR code data contains student ID
    $studentId = $qrCodeData['student_id'];

    // Validate student ID if needed
    // Example validation: Ensure student ID is numeric
    if (!is_numeric($studentId)) {
        return response()->json(['message' => 'Invalid student ID'], 400);
    }

    // Retrieve the student details
    $student = Student::find($studentId);

    if (!$student) {
        return response()->json(['message' => 'Student not found'], 404);
    }

    // Retrieve the latest worship session
    $latestWorshipSession = WorshipSession::latest()->first();

    // Check if a worship session exists
    if (!$latestWorshipSession) {
        return response()->json(['message' => 'No worship session found'], 400);
    }

    // Check if the latest worship session is completed
    if ($latestWorshipSession->status == 'Completed') {
        return response()->json(['message' => 'Worship session is closed'], 400);
    }

    // Retrieve the worship session ID
    $latestWorshipSessionId = $latestWorshipSession->id;

    // Check if the student has already been scanned for this worship session
    $existingAttendance = Worship::where('student_id', $studentId)
        ->where('worship_session_id', $latestWorshipSessionId)
        ->first();

    if ($existingAttendance) {
        // Student has already been scanned for this worship session
        return response()->json(['message' => 'Already scanned for this worship'], 400);
    }

    // Insert a new record in the worship table
    $attendance = Worship::create([
        'student_id' => $studentId,
        'attendance' => 1,
        'worship_session_id' => $latestWorshipSessionId,
    ]);

    // Retrieve the inserted worship_session_id
    $insertedWorshipSessionId = $attendance->worship_session_id;

    // Return the student details along with the response
    return response()->json([
        'message' => 'Attendance marked successfully',
        'worship_session_id' => $insertedWorshipSessionId,
        'student' => [
            'First_name' => $student->First_name,
            'Surname' => $student->Surname,
            'registration_number' => $student->registration_number,
        ],
    ]);
}


    // StudentController.php

    public function create()
    {
        return view('student.create');
    }


    

  public function storee(Request $request)
{
    $validatedData = $request->validate([
        'First_name' => 'required|string',
        'Surname' => 'required|string',
        'registration_number' => 'required|string',
        'program_of_study' => 'required|string',
        'gender' => 'required|string',
        'status' => 'required|string',
    ]);

    $student = new Student();
    $student->First_name = $validatedData['First_name'];
    $student->Surname = $validatedData['Surname'];
    $student->registration_number = $validatedData['registration_number'];
    $student->program_of_study = $validatedData['program_of_study'];
    $student->gender = $validatedData['gender'];
    $student->status = $validatedData['status'];

    $student->save();

    return redirect()->route('student.create')->with('success', 'Student registered successfully.');
}






    public function downloadPDF()
    {
        $students = Student::all(); // Assuming Student is the model for your students

        $pdf = PDF::loadView('student.all_qrcodes', compact('students'));
        return $pdf->download('students.pdf');
    }





public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls',
    ]);

    $file = $request->file('file');

    try {
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        foreach ($rows as $key => $row) {
            // Skip the header row
            if ($key == 0) {
                continue;
            }

            // Assuming your columns are: name, registration_number, gender, program_of_study,status
            $studentData = [
                'name' => $row[0],
                'registration_number' => $row[1],
                'gender' => $row[2],
                'program_of_study' => $row[3],
              
                'status' => $row[4],
                // Add other fields as needed
            ];

            Student::create($studentData);
        }

        return redirect()->back()->with('success', 'Students imported successfully.');
    } catch (PhpSpreadsheetException $e) {
        return redirect()->back()->with('error', 'Error loading file: ' . $e->getMessage());
    }
}

public function edit(Student $student)
{
    return view('student.edit', compact('student'));
}

public function update(Request $request, Student $student)
{
    $request->validate([
        'name' => 'required',
       
        'registration_number' => 'required',
        'program_of_study' => 'required',
        'gender'=> 'required',
        'status' => 'required',
    ]);

    $student->update([
        'name' => $request->input('name'),
       
        'registration_number' => $request->input('registration_number'),
        'program_of_study' => $request->input('program_of_study'),
       'gender' => $request->input('gender'),
        'status' => $request->input('status'),
    ]);

    return redirect()->route('attendance')->with('success', 'Student updated successfully.');
}

public function destroy(Student $student)
{
    $student->delete();
    return redirect()->route('attendance')->with('success', 'Student deleted successfully.');
}

// public function scanAttendance(Request $request)
// {
//     $qrCodeData = $request->input('qrCodeData');

//     if (empty($qrCodeData) || !is_string($qrCodeData)) {

//         return response()->json(['message' => 'Incalid QR Code data'], 400);

//         $student = Student::where('registration_number', $qrCodeData)->first();
        
//         if (!$student) {
            
//             return response()->json(['message' => 'student not found'], 4040);

    
//         }

//         $latestWorshipSession = WorshipSession::latest()->first();

//         if (!$latestWorshipSession) {
//             return response()->json(['message' => 'No worship session found'], 400);

//         }

//         if ($latestWorshipSession->status == 'completed') {
//             return response()->json(['message' => 'worship session is closed'], 400);

//         }

//         $latestWorshipSessionId = $latestWorshipSession->id;

//         $existingAttendance = Worship::where('student_id', $student->id)
//              ->where('worship_session_id', $latestWorshipSession)
//              ->first();

//         if()     
//     } 
// }


}

