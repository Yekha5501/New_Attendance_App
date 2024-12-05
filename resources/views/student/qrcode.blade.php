@extends('layouts.app')

@section('content')
    <div class="container mx-auto flex justify-center items-center h-screen">
        <!-- Single Student Card -->
        <div id="studentsGrid" class="bg-gray-300 shadow-lg rounded-xl overflow-hidden transition-shadow duration-300 hover:shadow-xl w-full max-w-xs" >
            <!-- Header Section -->
            <div class="bg-blue-500 p-4 text-center">
                <div class="flex items-center justify-center mb-2">
                    <img class="w-16 h-16 rounded-full border-4 border-white" src="{{ asset('storage/logo/logo.png') }}" alt="ID Photo">
                </div>
                 <div class="mb-2 text-white">
                    <h2 class="text-bs font-bold">{{ $student->name }} {{ $student->Surname }}</h2>
                    <p class="text-sm">{{ $student->registration_number }}</p>
                </div>
            </div>

            <!-- QR Code Section -->
            <div class="flex justify-center mt-4 mb-2">
                <img class="w-24 h-24" src="{{ Storage::url($student->qrcode_path) }}" alt="QR Code">
            </div>

            <!-- Contact Information -->
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
    </div>

    <!-- Download Button -->
    <div class="flex justify-center ">
        <button id="downloadBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <i class="fas fa-download mr-2"></i> Download PDF
        </button>
    </div>

    <!-- Script for PDF Generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script>
       function onClick() {
        const element = document.getElementById('studentsGrid');

            // Set options for PDF generation
            const opt = {
                margin:       [18, 15, 40, 15],  // Adjust the margins
                filename:     'student_info.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'mm', format: 'letter', orientation: 'portrait' }
            };

            // Use html2pdf to generate the PDF
            html2pdf().from(element).set(opt).save();
        }

        var element = document.getElementById("downloadBtn");
        element.addEventListener("click", onClick);
    </script>
@endsection
