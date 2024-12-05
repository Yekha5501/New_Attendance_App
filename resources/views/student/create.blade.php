@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mt-4 mb-4">
            <h2 class="text-center text-2xl font-bold mb-6">Register Student</h2>

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-4">

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <div class="grid wxl grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="First_name">First Name:</label>
                        <input name="First_name" id="First_name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="Surname">Surname:</label>
                        <input name="Surname" id="Surname" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="program_of_study">Program of Study:</label>
                        <select name="program_of_study" id="program_of_study" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="DCM">DCM</option>
                            <option value="DCM2">DCM2</option>
                            <option value="DCM3">DCM3</option>
                            <option value="BMS1">BMS1</option>
                            <option value="BMS2">BMS2</option>
                            <option value="BMS3">BMS3</option>
                            <option value="NMT1">NMT1</option>
                            <option value="NMT2">NMT2</option>
                            <option value="NMT3">NMT3</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="registration_number">Registration Number:</label>
                        <input name="registration_number" id="registration_number" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Gender:</label>
                        <select name="gender" id="gender" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="unspecified">Unspecified</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status:</label>
                        <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Register Student</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    setTimeout(function() {
        document.getElementById('successMessage').style.display = 'none';
    }, 3000); // 3000 milliseconds = 3 seconds
</script>
@endsection