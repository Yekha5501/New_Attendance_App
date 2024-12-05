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

class StudentsExportPhpSpreadsheet
{
    private $worshipSessions;

    public function __construct()
    {
        $this->worshipSessions = WorshipSession::all();
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headings
        $headings = $this->getHeadings();
        $sheet->fromArray($headings, NULL, 'A1');
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F4B084']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Set data
        $row = 2;
        foreach (Student::all() as $student) {
            $data = $this->map($student);
            $sheet->fromArray($data, NULL, 'A' . $row);
            $row++;
        }

        // Save the spreadsheet
        $writer = new Xlsx($spreadsheet);
        $filename = 'students.xlsx';
        $writer->save(Storage::path($filename));

        return response()->download(Storage::path($filename))->deleteFileAfterSend(true);
    }

    private function getHeadings(): array
    {
        $sessionDates = $this->worshipSessions->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        })->toArray();

        return array_merge(
            ['Name',  'Registration Number'],
            $sessionDates,
            ['Average Grade']
        );
    }

    private function map($student): array
    {
        $attendance = $this->worshipSessions->map(function ($session) use ($student) {
            $worship = Worship::where('student_id', $student->id)
                ->where('worship_session_id', $session->id)
                ->first();
            return $worship ? 1 : 0;
        })->toArray();

        return array_merge(
            [
               
                $student->name,
                $student->registration_number,
            ],
            $attendance,
            [
                $student->avg_grade
            ]
        );
    }
}
