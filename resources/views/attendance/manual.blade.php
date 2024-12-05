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

    <form action="{{ route('attendance.manual.submit') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="registration_number" class="block text-sm font-medium text-gray-700">Student Registration Number</label>
            <input type="text" name="registration_number" id="registration_number" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Enter Registration Number" required>
        </div>

        <div>
            <label for="worship_session_id" class="block text-sm font-medium text-gray-700">Select Worship Session</label>
            <select name="worship_session_id" id="worship_session_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
                @foreach($worshipSessions as $session)
                    <option value="{{ $session->id }}">
                        {{ $session->date }} - {{ $session->type }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-md transition duration-200">Mark Attendance</button>
    </form>
</div>
@endsection
