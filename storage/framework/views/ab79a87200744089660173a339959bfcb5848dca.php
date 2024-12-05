<?php $__env->startSection('content'); ?>
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="card p-4">
            <div class="bg-blue-900 text-white rounded-t-lg p-4 text-center">
                <h5 class="text-lg font-semibold"><?php echo e($student->First_name); ?> <?php echo e($student->Surname); ?></h5>
                <p class="text-sm mt-2"><?php echo e($student->registration_number); ?></p>
            </div>
            <div class="card-body">
                <img src="<?php echo e(Storage::url($student->qrcode_path)); ?>" alt="QR Code" class="img-fluid mx-auto">
            </div>
        </div>
    </div>

    <div class="flex justify-center mt-4">
        <button id="downloadBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <i class="fas fa-download mr-2"></i> Download PDF
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
        function onClick() {
            const element = document.querySelector('.card');

            // Set options for PDF generation
            const opt = {
                margin:       1,
                filename:     'student_info.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };

            // Use html2pdf to generate the PDF
            html2pdf().from(element).set(opt).save();
        }

        var element = document.getElementById("downloadBtn");
        element.addEventListener("click", onClick);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/1292223.cloudwaysapps.com/bwwzkatavt/public_html/resources/views/student/qrcode.blade.php ENDPATH**/ ?>