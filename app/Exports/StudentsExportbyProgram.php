<?php
namespace App\Exports;

use App\Models\Student;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Storage;

class StudentsExportbyProgram
{
    private $program;

    public function __construct($program)
    {
        $this->program = $program;
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

        // Set data, now ordered by name
        $row = 2;
        $students = Student::where('program_of_study', $this->program)
                            ->orderBy('name', 'asc') // Order by student name in alphabetical order
                            ->get();
        foreach ($students as $student) {
            $data = $this->map($student);
            $sheet->fromArray($data, NULL, 'A' . $row);
            $row++;
        }

        // Save the spreadsheet
        $writer = new Xlsx($spreadsheet);
        $filename = $this->program . '.xlsx';
        $writer->save(Storage::path($filename));

        return response()->download(Storage::path($filename))->deleteFileAfterSend(true);
    }

    private function getHeadings(): array
    {
        return [
            'Name',
            'Registration Number',
            'Average Grade'
        ];
    }

    private function map($student): array
    {
        return [
            $student->name,
            $student->registration_number,
            $student->avg_grade
        ];
    }
}
