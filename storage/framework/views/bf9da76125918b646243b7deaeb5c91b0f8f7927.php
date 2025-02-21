

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold text-gray-700 mb-4">Manual Attendance</h1>

    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>
<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-xl font-bold mb-4">Upload Attendance</h2>

        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('attendance.upload')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <?php echo csrf_field(); ?>
            <input type="file" name="attendance_file" accept=".xlsx,.xls,.csv" required class="block w-full border p-2 rounded">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload</button>
        </form>
    </div>

</body>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\New_Attendance_App\resources\views/attendance/upload.blade.php ENDPATH**/ ?>