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
        /* resources/css/custom.css */
        body {
            margin-top: 20px;
            /* Adjust the value as needed */
        }
    </style>

</head>

<body style="margin-top: 40px;">

 

    
    <div class="max-w-6xl custom-margin-top mt-16 mx-auto bg-white shadow-md rounded-lg overflow-hidden">
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
        <div class="px-6 py-4">
            <h1 class="text-xl font-semibold">Student Attendance</h1>
        </div>
        <!-- Inside your view where you want the button to appear -->


        <div class="inline-flex rounded-md  px-6 py-4">
            <a href="{{ route('worship-sessions.create') }}" aria-current="page" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-2 border-blue-700 rounded-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                Create Worship
            </a>

        </div>
        <div class="px-6 py-4">
            <label for="sessionTypeFilter">Filter by Session Type:</label>
            <select id="sessionTypeFilter" onchange="filterBySessionType()">
                <option value="all">All</option>
                <option value="Morning">Morning</option>
                <option value="Evening">Evening</option>
            </select>
            <table id="myTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Worship Session ID</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($worshipSessions as $worshipSession)
                    <tr>
                        <td>{{ $worshipSession->id }}</td>
                        <td>{{ $worshipSession->title }}</td>
                        <td>{{ $worshipSession->date }}</td>
                        <td>{{ $worshipSession->type }}</td>
                        <td>
                            @if ($worshipSession->status == 'Completed')
                            <span class="bg-green-200 text-green-800 py-1 px-2 rounded-full">Completed</span>
                            @else
                            <span class="bg-red-200 text-red-800 py-1 px-2 rounded-full">In Progress</span>
                            @endif
                        </td>
                        <td class="flex space-x-2">
                            <!-- Existing buttons -->
                            @if ($worshipSession->status == 'Progress')
                            <form action="{{ route('mark-session', $worshipSession->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-700 hover:text-red-900" title="Mark as Completed">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('set-progress', $worshipSession->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-700 hover:text-blue-900" title="Set Back to Progress">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </form>
                            @endif

                            <!-- New Manual Attendance Button -->
                            <a href="{{ route('worship-sessions.manual-attendance', $worshipSession->id) }}" class="text-green-700 hover:text-green-900" title="Add Manual Attendance">
                                <i class="fas fa-user-check"></i>
                            </a>
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });
    </script>

    <script>
        function filterBySessionType() {
            var tableRows = document.querySelectorAll('#myTable tbody tr');
            var selectedSessionType = document.getElementById('sessionTypeFilter').value;

            tableRows.forEach(function(row) {
                var sessionType = row.cells[3].innerText.trim(); // Assuming the session type is in the 4th column
                if (selectedSessionType === 'all' || sessionType === selectedSessionType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
@endsection