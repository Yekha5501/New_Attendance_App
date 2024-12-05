<div class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">
        Welcome to the Worship Attendance Tracking System, {{ $user->name }}
    </h1>
    <p class="text-gray-600 mb-2">
        Your account has been created successfully.
    </p>
    <p class="text-gray-800 font-semibold mb-2">
        <strong>Email:</strong> {{ $user->email }}
    </p>
    <p class="text-gray-800 font-semibold mb-4">
        <strong>Password:</strong> {{ $password }}
    </p>
    <p class="text-red-600">
        For your security, please keep your password confidential and do not share it with anyone.
    </p>

</div>