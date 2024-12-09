<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Worship Grade Report</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
        <h1 class="text-2xl font-bold mb-4">Hello!</h1>
        <p class="mb-6">You have a new worship grade report available. Click the button below to view your results.</p>
        <a href="<?php echo e(route('view.results')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Results</a>
    </div>
</body>
</html>
<?php /**PATH C:\wamp64\www\New_Attendance_App\resources\views/emails/test.blade.php ENDPATH**/ ?>