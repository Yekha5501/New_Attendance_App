<?php $__env->startSection('content'); ?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Table Example</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.4.1/dist/flowbite.min.js"></script>


</head>

<body>

    <?php if(session('success')): ?>
    <div id="successMessage" class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('status')): ?>
    <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        <?php echo e(session('status')); ?>

    </div>
    <?php endif; ?>

    <div class="max-w-6xl mt-5 mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-6 py-4">
            <h1 class="text-xl font-semibold">System Users</h1>
        </div>
        <!-- Inside your view where you want the button to appear -->


        <div class="inline-flex rounded-md border-blue-500 shadow-sm px-6 py-4">
            <!-- <a href="<?php echo e(url('/generate-qrcodes')); ?>" aria-current="page" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                Generate QRCodes
            </a> -->
            <a href="<?php echo e(route('register')); ?>" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg  hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                Register
            </a>
            <!-- <a href="#" class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                Check percentile
            </a> -->
        </div>


        <div class="relative p-2 overflow-x-auto shadow-md sm:rounded-lg">
            
            <table id="export-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" id="userTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Role
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $mobileUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <?php echo e($user->name); ?>

                        </th>
                        <td class="px-6 py-4">
                            <?php echo e($user->email); ?>

                        </td>
                        <td class="px-6 py-4">
                            <?php echo e($user->role); ?>

                        </td>
                        <td class="px-6 py-4">
                            <?php if($user->is_online): ?>
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div> Online
                            </div>
                            <?php else: ?>
                            <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div> Offline
                            </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-blue-500 hover:text-blue-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>

                            <a href="#" class="text-blue-500 hover:text-blue-700">
                                <i class="fas fa-qrcode"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>



    </div>

    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                responsive: true
            });
        });
    </script>

    <script>
        setTimeout(function() {
            document.getElementById('successMessage').style.display = 'none';
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>

    <script>
        function filterBySessionType() {
            var tableRows = document.querySelectorAll('#myTable tbody tr');
            var selectedSessionType = document.getElementById('sessionTypeFilter').value;

            tableRows.forEach(function(row) {
                var sessionType = row.cells[2].innerText.trim(); // Assuming the session type is in the 4th column
                if (selectedSessionType === 'all' || sessionType === selectedSessionType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

    <script>
        function searchTable() {
            let input = document.getElementById('table-search');
            let filter = input.value.toLowerCase();
            let table = document.getElementById('userTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let tds = tr[i].getElementsByTagName('td');
                let match = false;
                for (let j = 0; j < tds.length; j++) {
                    if (tds[j] && tds[j].innerText.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
                if (match) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    </script>


</body>

</html>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1292223.cloudwaysapps.com/bwwzkatavt/public_html/resources/views/mobile-users/index.blade.php ENDPATH**/ ?>