<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DailyActivityController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\AttendanceQrController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (public)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected routes (require login)
    Route::middleware('auth')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Students
        Route::post('students/import', [StudentController::class, 'import'])->name('students.import');
        Route::resource('students', StudentController::class);

        // Enrollments/Attendances
        Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');

        // Daily Activities
        Route::get('daily-activities', [DailyActivityController::class, 'index'])->name('daily_activities.index');
        Route::get('daily-activities/pdf', [DailyActivityController::class, 'generatePdf'])->name('daily_activities.pdf');

        // Leave Requests
        Route::get('leave-requests', [LeaveRequestController::class, 'index'])->name('leave_requests.index');
        Route::patch('leave-requests/{leaveRequest}/verify', [LeaveRequestController::class, 'verify'])->name('leave_requests.verify');

        // Tasks Management
        Route::resource('tasks', TaskController::class);

        // Attendance QR
        Route::get('attendance-qrs', [AttendanceQrController::class, 'index'])->name('attendance_qrs.index');
        Route::post('attendance-qrs/generate', [AttendanceQrController::class, 'generate'])->name('attendance_qrs.generate');
    });
});

Route::get('/storage/leave_requests/{filename}', function ($filename) {
    $path = storage_path('app/public/leave_requests/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});
