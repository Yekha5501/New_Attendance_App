<?php $__env->startSection('content'); ?>
<style>
    /* Custom styles for PDF generation */
    @media  print {
        .page-break {
            page-break-before: always;
        }
    }
</style>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<div class="container bg-white mx-auto">
    <h3 class="text-center my-5 text-gray-800">All Students and Their QR Codes</h3>

    <!-- Download button styled with Tailwind CSS -->
    <div class="flex justify-end mb-5">
        <button id="downloadBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <i class="fas fa-download mr-2"></i> Download PDF
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2  lg:grid-cols-3 gap-6" id="studentsGrid">
        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-gray-300 shadow-lg  rounded-xl overflow-hidden transition-shadow duration-300 hover:shadow-xl">
            <div class="bg-blue-500 p-4 text-center">
                <div class="flex items-center justify-center mb-2">
                    <img class="w-16 h-16 rounded-full border-4 border-white" src="<?php echo e(asset('storage/logo/logo.png')); ?>" alt="ID Photo">
                </div>
                <div class="mb-2 text-white">
                    <h2 class="text-bs font-bold"><?php echo e($student->name); ?> <?php echo e($student->Surname); ?></h2>
                    <p class="text-sm"><?php echo e($student->registration_number); ?></p>
                </div>
            </div>
            <div class="flex justify-center mt-4 mb-2">
                <img class="w-24 h-24" src="<?php echo e(Storage::url($student->qrcode_path)); ?>" alt="QR Code">
            </div>
            <div class="text-center px-4 pb-4">
                <div class="bg-blue-50 p-3 rounded-lg shadow-md">
                    <p class="text-gray-600 mb-1 flex items-center justify-center text-sm">
                        <i class="fas fa-envelope mr-1 text-blue-500"></i>
                        admin@mchs.org
                    </p>
                    <p class="text-gray-600 flex items-center justify-center text-sm">
                        <i class="fas fa-phone mr-1 text-blue-500"></i>
                        +265 991 295 313
                    </p>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    function onClick() {
        const element = document.getElementById('studentsGrid');

        // Set options for PDF generation
        const opt = {
            margin: [18, 15, 40, 15],
            // Set only the top margin to 20mm
            filename: 'students.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'letter',
                orientation: 'portrait'
            }
        };

        // Use html2pdf to generate the PDF
        html2pdf().from(element).set(opt).save();
    }

    var element = document.getElementById("downloadBtn");
    element.addEventListener("click", onClick);
</script>

 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1292223.cloudwaysapps.com/bwwzkatavt/public_html/resources/views/student/all_qrcodes.blade.php ENDPATH**/ ?>