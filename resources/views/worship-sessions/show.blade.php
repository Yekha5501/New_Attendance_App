@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html>

<head>
    <title>Student Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin-top: 20px;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="max-w-6xl mt-16 mx-auto bg-white shadow-md rounded-lg overflow-hidden">
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

        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('worship-sessions.create') }}" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-2 border-blue-700 rounded-lg hover:bg-gray-100">
                    Create Worship
                </a>
                <input type="text" id="searchInput" placeholder="Search..." class="w-1/4 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="searchTable()">
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg px-6 py-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                       
                        <th class="px-6 py-3">Title</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach($worshipSessions as $worshipSession)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                 
                        <td class="px-6 py-4">{{ $worshipSession->title }}</td>
                        <td class="px-6 py-4">{{ $worshipSession->date }}</td>
                        <td class="px-6 py-4">{{ $worshipSession->type }}</td>
                        <td class="px-6 py-4">
                            @if ($worshipSession->status == 'Completed')
                            <span class="bg-green-200 text-green-800 py-1 px-2 rounded-full">Completed</span>
                            @else
                            <span class="bg-red-200 text-red-800 py-1 px-2 rounded-full">In Progress</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
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
                            <a href="{{ route('worship-sessions.manual-attendance', $worshipSession->id) }}" class="text-green-700 hover:text-green-900" title="Add Manual Attendance">
                                <i class="fas fa-user-check"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 px-6">
            {{ $worshipSessions->links('vendor.pagination.tailwind') }}
        </div>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const rows = document.querySelectorAll("#tableBody tr");

            rows.forEach(row => {
                const cells = Array.from(row.children);
                const match = cells.some(cell => cell.textContent.toLowerCase().includes(input));
                row.style.display = match ? "" : "none";
            });
        }
    </script>

</body>

</html>
@endsection
