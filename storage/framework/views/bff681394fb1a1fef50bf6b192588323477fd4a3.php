<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-lg">
        <div class="bg-white shadow-lg rounded-lg px-8 py-6">
            <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Download Student Results by Program</h2>

            <!-- Tab Navigation with Alpine.js (No Transition) -->
            <div x-data="{ activeTab: 'tab1' }">
                <ul class="flex justify-center space-x-4 border-b mb-4">
                    <li>
                        <a
                            @click="activeTab = 'tab1'"
                            :class="activeTab === 'tab1' ? 'border-b-4 border-blue-500 text-blue-600' : 'text-gray-500'"
                            class="inline-block py-2 px-6 font-medium cursor-pointer hover:text-blue-600 transition-colors duration-200 ease-in-out">
                            Accumulated
                        </a>
                    </li>
                    <li>
                        <a
                            @click="activeTab = 'tab2'"
                            :class="activeTab === 'tab2' ? 'border-b-4 border-blue-500 text-blue-600' : 'text-gray-500'"
                            class="inline-block py-2 px-6 font-medium cursor-pointer hover:text-blue-600 transition-colors duration-200 ease-in-out">
                            Monthly
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="content">
                    <!-- Tab 1: Without Month -->
                    <div x-show="activeTab === 'tab1'" class="focus-visible">
                        <form action="<?php echo e(route('download.excel')); ?>" method="GET">
                            <div class="mb-6">
                                <label for="program" class="block text-sm font-semibold text-gray-700 mb-2">Select Program:</label>
                                <select name="program" id="program" class="block w-full bg-gray-100 border border-gray-300 text-gray-700 py-3 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program); ?>"><?php echo e($program); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="mt-4">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200 ease-in-out">Download Excel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Tab 2: With Month -->
                    <div x-show="activeTab === 'tab2'" class="focus-visible">
                        <form action="<?php echo e(route('downloadExcelWithMonth')); ?>" method="GET">
                            <div class="mb-6">
                                <label for="program" class="block text-sm font-semibold text-gray-700 mb-2">Select Program:</label>
                                <select name="program" id="program" class="block w-full bg-gray-100 border border-gray-300 text-gray-700 py-3 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program); ?>"><?php echo e($program); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">Select Month:</label>
                                <select name="month_year" id="month_year" class="block w-full bg-gray-100 border border-gray-300 text-gray-700 py-3 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($month->month_year); ?>"><?php echo e(date('F Y', strtotime($month->month_year . '-01'))); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded transition duration-200 ease-in-out">Download Excel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1292223.cloudwaysapps.com/bwwzkatavt/public_html/resources/views/report.blade.php ENDPATH**/ ?>