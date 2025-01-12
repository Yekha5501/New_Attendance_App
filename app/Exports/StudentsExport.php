<?php

namespace App\Exports;

use App\Models\Student;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Storage;

class StudentsExport
{
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
        $students = Student::all();
        foreach ($students as $student) {
            $data = $this->map($student);
            $sheet->fromArray($data, NULL, 'A' . $row);
            $row++;
        }

        // Save the spreadsheet
        $writer = new Xlsx($spreadsheet);
        $filename = 'students_data.xlsx';
        $writer->save(Storage::path($filename));

        return response()->download(Storage::path($filename))->deleteFileAfterSend(true);
    }

    private function getHeadings(): array
    {
        return ['Name', 'Registration Number', 'Program', ' Grade Percentage'];
    }

    private function map($student): array
    {
        return [
            $student->name,
            $student->registration_number,
            $student->program_of_study,
            $student->avg_grade
        ];
    }
}
