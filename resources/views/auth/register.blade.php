@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mt-4 mb-4">
            <h2 class="text-center text-2xl font-bold mb-6">Register</h2>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('status'))
                <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 ">
                    {{ session('status') }}
                </div>
            @endif
            
            <form action="{{ route('register_user') }}" method="POST">
                @csrf
                <div class="mb-4 ">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Username</label>
                    <input name="name" id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                    <input name="email" id="email" type="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('email') }}" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                    <input name="password" id="password" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Confirm Password</label>
                    <input name="password_confirmation" id="password_confirmation" type="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="role">Role</label>
                    <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="web" {{ old('role') == 'web' ? 'selected' : '' }}>Web</option>
                        <option value="mobile" {{ old('role') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                    </select>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register</button>
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
