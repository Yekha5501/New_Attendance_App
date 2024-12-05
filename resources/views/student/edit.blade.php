@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mt-4 mb-4">
            <h2 class="text-center text-2xl font-bold mb-6">Edit Student</h2>

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

            <form action="{{ route('students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4 ">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name:</label>
                    <input name="name" id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $student->name }}" required>
                </div>



                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="registration_number">Registration Number:</label>
                    <input name="registration_number" id="registration_number" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $student->registration_number }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="program_of_study">Program of Study:</label>
                    <select name="program_of_study" id="program_of_study" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="DCM" {{ $student->program_of_study == 'DCM'? 'selected' : '' }}>DCM</option>
                        <option value="DCM2" {{ $student->program_of_study == 'DCM2'? 'selected' : '' }}>DCM2</option>
                        <option value="DCM3" {{ $student->program_of_study == 'DCM3'? 'selected' : '' }}>DCM3</option>
                        <option value="BMS1" {{ $student->program_of_study == 'BMS1'? 'selected' : '' }}>BMS1</option>
                        <option value="BMS2" {{ $student->program_of_study == 'BMS2'? 'selected' : '' }}>BMS2</option>
                        <option value="BMS3" {{ $student->program_of_study == 'BMS3'? 'selected' : '' }}>BMS3</option>
                        <option value="NMT1" {{ $student->program_of_study == 'NMT1'? 'selected' : '' }}>NMT1</option>
                        <option value="NMT2" {{ $student->program_of_study == 'NMT2'? 'selected' : '' }}>NMT2</option>
                        <option value="NMT3" {{ $student->program_of_study == 'NMT3'? 'selected' : '' }}>NMT3</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="gender">Gender</label>
                    <select name="gender" id="gender" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="male" {{ $student->gender == 'male'? 'elected' : '' }}>Male</option>
                        <option value="female" {{ $student->gender == 'female'? 'elected' : '' }}>Female</option>
                        <option value="unspecified" {{ $student->gender == 'unspecified'? 'elected' : '' }}>Unspecified</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="status">Status:</label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="Active" {{ $student->status == 'Active'? 'elected' : '' }}>Active</option>
                        <option value="Inactive" {{ $student->status == 'Inactive'? 'elected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Student</button>
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