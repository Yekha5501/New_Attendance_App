<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <style>
        @media (max-width: 640px) {
            .login-card {
                width: 90%;
                padding: 2rem;
                margin: 0;
                border-radius: 0;
                min-height: 10vh;
                border-radius: 5px;
            }
        }
    </style>
</head>
<body class="bg-gray-200">
<div class="min-h-screen flex items-center justify-center border-4 border-blue-500">
    <div class="login-card max-w-md w-full mx-auto p-8 bg-white rounded-lg shadow-lg">
        <!-- Logo Section -->
        <div class="text-2xl font-bold text-center"><?php echo e(__('ShopKlip')); ?></div>

        <div class="flex justify-center mt-4 mb-4">
            <img src="<?php echo e(asset('storage/logo/logo.png')); ?>" alt="Logo" class="h-24 w-24">
        </div>
        <!-- Login Form -->
        <form method="POST" action="<?php echo e(route('login')); ?>" class="mt-4">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700"><?php echo e(__('Email Address')); ?></label>
                <input id="email" type="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-1" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700"><?php echo e(__('Password')); ?></label>
                <input id="password" type="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required autocomplete="current-password">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="text-red-500 text-xs mt-1" role="alert">
                    <strong><?php echo e($message); ?></strong>
                </span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="mb-4 flex items-center">
                <input class="mr-2" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                <label class="text-sm text-gray-600" for="remember">
                    <?php echo e(__('Remember Me')); ?>

                </label>
            </div>
            <div class="mb-4">
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    <?php echo e(__('Login')); ?>

                </button>
            </div>
            <?php if(Route::has('password.request')): ?>
            <div class="text-sm text-center">
                <a class="text-blue-500 hover:text-blue-700" href="<?php echo e(route('password.request')); ?>">
                    <?php echo e(__('Forgot Your Password?')); ?>

                </a>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>
</body>
</html>
<?php /**PATH C:\wamp64\www\New_Attendance_App\resources\views/auth/login.blade.php ENDPATH**/ ?>