@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold text-gray-700 mb-4">Manual Attendance</h1>

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
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-4">Upload Attendance</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('attendance.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="file" name="attendance_file" accept=".xlsx,.xls,.csv" required class="block w-full border p-2 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload</button>
        </form>
    </div>

</body>
@endsection