@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold my-4">Final Attendance Report</h2>

    <div class="overflow-x-auto">

          <form action="{{ route('pdf-report') }}" method="get">
        <button type="submit" class="btn btn-primary">Download Final Report as PDF</button>
    </form>
          <form action="{{ route('exportToExcel') }}" method="get">
        <button type="submit" class="btn btn-primary">Download Final Report as excel</button>
    </form>
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Surname</th>
                    <th class="border px-4 py-2">Reg Number</th>
                    @foreach($worshipSessions as $session)
                        <th class="border px-4 py-2">{{ $session->date }}</th>
                    @endforeach
                    <th class="border px-4 py-2">Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendanceRecords as $record)
                    <tr>
                        <td class="border px-4 py-2">{{ $record['student']->First_name }}</td>
                        <td class="border px-4 py-2">{{ $record['student']->Surname }}</td>
                        <td class="border px-4 py-2">{{ $record['student']->registration_number }}</td>
                        @foreach($record['attendance'] as $date => $attended)
                            <td class="border px-4 py-2 text-center">
                                {{ $attended }}
                            </td>
                        @endforeach
                        <td class="border px-4 py-2">{{ $record['student']->avg_grade }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
