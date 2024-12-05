<!-- resources/views/upload-image.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Upload Profile Image
            </h2>
        </div>
        <form class="mt-8 space-y-6" method="POST" action="{{ route('update-profile-image') }}" enctype="multipart/form-data">
            @csrf
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="image" class="sr-only">Select Image</label>
                    <input id="image" name="image" type="file" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Select Image">
                </div>
            </div>
            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-700 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Upload
                </button>
            </div>
        </form>

         @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p>{{ session('success') }}</p>
            </div>
            <script>
                setTimeout(function() {
                    document.querySelector('.bg-green-100').classList.add('hidden');
                }, 3000);
            </script>
        @endif
    </div>
</div>
@endsection
