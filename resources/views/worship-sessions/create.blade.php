@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-200">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mt-4 mb-4">
            <h2 class="text-center text-2xl font-bold mb-6">Create Worship Session</h2>
            
            @if (\Session::has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ \Session::get('error') }}
                </div>
            @endif
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{ route('worship-sessions.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Title</label>
                    <input name="title" id="title" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="date">Date</label>
                    <input name="date" id="date" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="session_type">Session Type</label>
                    <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="Morning">Morning Session</option>
                        <option value="Evening">Evening Session</option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Session</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        document.getElementById('successMessage').style.display = 'none';
    }, 3000); // 3000 milliseconds = 3 seconds
</script>

@endsection