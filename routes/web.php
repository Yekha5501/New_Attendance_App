<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WorshipSessionController;
use App\Models\WorshipSession;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\EmailController;
use FontLib\Table\Type\name;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', function () {
    return view('auth.login'); // This route points to the login view
}); //Routes by Pempho


Route::get('/get-excel', function () {
    $path = storage_path('app/students_data_20250216_132712.xlsx');
    if (!file_exists($path)) {
        return response()->json(['error' => 'File not found'], 404);
    }
    return response()->download($path);
});
  Route::post('/ask-ai', [ChatbotController::class, 'askAI']);
 Route::post('/query', [ChatbotController::class, 'query']);

    Route::get('/chatbot', function () {
    return view('chatbot'); // Make sure you have chatbot.blade.php in resources/views
});

//Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/attendance', [AttendanceController::class, 'showAttendance'])->name('attendance');
    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

  



    // Route to show the manual attendance form
    Route::get('/attendance/manual', [AttendanceController::class, 'showManualAttendanceForm'])->name('attendance.manual');
    // Route to handle the form submission
    Route::post('/attendance/manual', [AttendanceController::class, 'manualAttendance'])->name('attendance.manual.submit');
    Route::get('/worship-sessions/{id}/manual-attendance', [WorshipSessionController::class, 'showManualAttendanceForm'])->name('worship-sessions.manual-attendance');
    Route::post('/worship-sessions/{id}/store-attendance', [WorshipSessionController::class, 'storeAttendance'])->name('worship-sessions.store-attendance');



    Route::get('/attendance/upload', [AttendanceController::class, 'showUploadForm'])->name('attendance.upload.form');
    Route::post('/attendance/upload', [AttendanceController::class, 'uploadAttendance'])->name('attendance.upload');



    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/attendance', [AttendanceController::class, 'showAttendance'])->name('attendance');
    Route::get('/generate-qrcodes', [AttendanceController::class, 'generateQRCodes']);
    Route::get('/calculate-attendance-percentages', [AttendanceController::class, 'calculateAttendancePercentage'])->name('attendance.calculate');
    Route::get('/students/create', [AttendanceController::class, 'create'])->name('student.create');
    Route::get('/students', [AttendanceController::class, 'storre'])->name('students.store');
    // Define the registration route with a name
    Route::post('/students', [AttendanceController::class, 'storee'])->name('students.store');


    Route::get('/register', [HomeController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [HomeController::class, 'register'])->name('register_user');

    Route::get('users/{id}/edit', [HomeController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [HomeController::class, 'update'])->name('users.update');





    // Route::get('/calculate-attendance-percentages', 'AttendanceController@calculateAttendancePercentage')->name('attendance.calculate');


    Route::get('students/{student}/qrcode', [AttendanceController::class, 'viewQRCode'])->name('students.qrcode');
    Route::get('/students/all-qrcodes', [AttendanceController::class, 'viewALLQRCode'])->name('students.all-qrcodes');
    Route::get('worship-sessions/create', [WorshipSessionController::class, 'create'])->name('worship-sessions.create');
    Route::post('/mark-session/{id}', [WorshipSessionController::class, 'markSession'])->name('mark-session');
    Route::post('/set-progress/{id}', [WorshipSessionController::class, 'setProgress'])->name('set-progress');
    Route::get('worship-sessions/show', [WorshipSessionController::class, 'show'])->name('worship-sessions.show');
    Route::post('worship-sessions/store', [WorshipSessionController::class, 'store'])->name('worship-sessions.store');
    Route::post('/profile/update-image', [HomeController::class, 'updateImage'])->name('update-profile-image');
    Route::get('/download-pdf', [AttendanceController::class, 'downloadPDF'])->name('downloadPDF');
    Route::get('final-report', [WorshipSessionController::class, 'finalReport'])->name('final-report');
    Route::get('pdf-report', [WorshipSessionController::class, 'PdfReport'])->name('pdf-report');
    Route::get('students/excel', [WorshipSessionController::class, 'exportToExcel'])->name('exportToExcel');
    Route::get('/download-excel', [WorshipSessionController::class, 'downloadExcel'])->name('download.excel');
    Route::get('/downloadExcelWithMonth', [WorshipSessionController::class, 'downloadExcelWithMonth'])->name('downloadExcelWithMonth');
    // routes/web.php



    Route::get('/profile/upload-image', [HomeController::class, 'showUploadForm'])->name('upload-profile-image');
    Route::get('/mobile-users', 'App\Http\Controllers\MobileUserController@index')->name('mobile-users.index');
    Route::post('/import-students', [AttendanceController::class, 'import'])->name('students.import');
    Route::get('students/{student}/edit', [AttendanceController::class, 'edit'])->name('students.edit');
    Route::put('students/{student}', [AttendanceController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [AttendanceController::class, 'destroy'])->name('students.destroy');
    Route::get('students/{student}/edit', [AttendanceController::class, 'edit'])->name('students.edit');
    Route::put('students/{student}', [AttendanceController::class, 'update'])->name('students.update');
    Route::delete('/students/{student}', [AttendanceController::class, 'destroy'])->name('students.destroy');
    Route::get('/report', [WorshipSessionController::class, 'report'])->name('report');
    Route::get('/export', [WorshipSessionController::class, 'export'])->name('export');
    Route::get('/send-email', [EmailController::class, 'sendEmail'])->name('sendEmail');
    Route::delete('/users/{user}', [HomeController::class, 'destroy'])->name('users.destroy');
});

Route::get('/view-results', [EmailController::class, 'viewResults'])->name('view.results');
