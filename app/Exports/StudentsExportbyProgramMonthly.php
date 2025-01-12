<?php

namespace App\Exports;

use App\Models\Student;
use App\Models\Worship;
use App\Models\WorshipSession;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class StudentsExportbyProgramMonthly
{
    private $program;
    private $monthYear;

    public function __construct($program, $monthYear = null)
    {
        // Default to current month/year if not provided
        $this->program = $program;
        $this->monthYear = $monthYear ?? date('Y-m');
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column headings
        $headings = $this->getHeadings();
        $sheet->fromArray($headings, NULL, 'A1');

        // Apply heading styles
        $sheet->getStyle('A1:D1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F4B084']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Fetch students for the specified program, sorted alphabetically by name
        $students = Student::where('program_of_study', $this->program)
            ->orderBy('name', 'asc') // Sort by name in ascending order
            ->get();

        if ($students->isEmpty()) {
            return response()->json(['error' => 'No students found for the specified program.'], 404);
        }

        // Fetch total worship sessions in the specified month
        $totalWorshipSessions = WorshipSession::where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $this->monthYear)->count();

        if ($totalWorshipSessions == 0) {
            return response()->json(['error' => 'No worship sessions found for the specified month.'], 404);
        }

        // Iterate over students and populate their attendance data
        $row = 2;
        foreach ($students as $student) {
            // Fetch attended sessions for the student in the specified month
            $attendedSessions = Worship::where('student_id', $student->id)
                ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), $this->monthYear)
                ->count();

            // Calculate grade as a percentage
            $attendanceGrade = ($totalWorshipSessions > 0) ? round(($attendedSessions / $totalWorshipSessions) * 100) : 0;

            // Prepare student data for export
            $data = [
                $student->name,
                $attendedSessions,
                $totalWorshipSessions,
                $attendanceGrade . '%',
            ];

            // Write student data to the sheet
            $sheet->fromArray($data, NULL, 'A' . $row);
            $row++;
        }

        // Auto-size all relevant columns for better visibility
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Right-align numerical values for clarity
        $sheet->getStyle('B2:D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        // Save the spreadsheet to storage
        // $writer = new Xlsx($spreadsheet);
        // $filename = $this->program . '-' . $this->monthYear . '.xlsx'; // Include program and monthYear in filename
        // $writer->save(Storage::path($filename));


        $writer = new Xlsx($spreadsheet);
        $sanitizedProgramName = str_replace(['/', '\\'], '-', $this->program); // Sanitize program name
        $filename = $sanitizedProgramName . '-' . $this->monthYear . '.xlsx'; // Use sanitized name
        $writer->save(Storage::path($filename));


        // Download the file and delete after sending
        return response()->download(Storage::path($filename))->deleteFileAfterSend(true);
    }

    // Method to define the column headings
    private function getHeadings(): array
    {
        return [
            'Name',
            'Attended Sessions',
            'Total Worship Sessions',
            'Grade Percentage',
        ];
    }
}
