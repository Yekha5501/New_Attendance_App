@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html>

<head>
    <title>Data Table Example</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* Custom styles */
        body {
            margin-top: 20px;
            background: linear-gradient(135deg, #34d399, #60a5fa);
        }

        .gradient-text {
          background: linear-gradient(to right, #d946ef, #8b5cf6, #3b82f6);

            -webkit-background-clip: text;
            color: transparent;
        }

        .table-container {
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-top: 50px;
        }

        .card-header {
            background-color: #f8fafc;
            border-bottom: 2px solid #e5e7eb;
        }
    </style>

</head>

<body style="margin-top: 40px;">
    
<div class="max-w-6xl mx-auto table-container">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="px-6 py-4 card-header">
        <h1 class="text-2xl font-semibold gradient-text">Manual Attendance for {{ $worshipSession->title }} - {{ $worshipSession->date }}</h1>
    </div>

    <!-- Program Filter Dropdown -->
    <div class="px-6 py-4">
        <select id="programFilter" class="px-4 py-2 border rounded">
            <option value="">Filter by Program</option>
            @foreach($students->pluck('program_of_study')->unique() as $program)
                <option value="{{ $program }}">{{ $program }}</option>
            @endforeach
        </select>
    </div>

    <form action="{{ route('worship-sessions.store-attendance', $worshipSession->id) }}" method="POST">
        @csrf
        <div class="px-6 py-4">
            <table id="myTable" class="table-auto w-full text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">Student Name</th>
                        <th class="px-4 py-2">Student ID</th>
                        <th class="px-4 py-2">Program</th>
                        <th class="px-4 py-2">Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $student->name }}</td>
                        <td class="border px-4 py-2">{{ $student->registration_number }}</td>
                        <td class="border px-4 py-2">{{ $student->program_of_study }}</td>
                        <td class="border px-4 py-2 text-center">
                            <label>
                                <input type="checkbox" 
                                       name="attendance[{{ $student->id }}]" 
                                       value="1" 
                                       {{ $student->attended ? 'checked disabled' : '' }}>
                            </label>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Mark Attendance</button>
        </div>
    </form>
</div>

<!-- DataTables JS & Initialization -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            responsive: true
        });

        // Filter the table by program
        $('#programFilter').on('change', function() {
            var program = $(this).val();
            table.column(2).search(program).draw(); // Column 2 is 'Program'
        });
    });
</script>

</body>
@endsection
