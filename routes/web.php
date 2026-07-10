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
use App\Http\Controllers\SettingsController;

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

        // Enrollments/Attendances
        Route::get('attendances', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::post('attendances/mark-absent', [AttendanceController::class, 'markAbsent'])->name('attendances.mark_absent');

        // Daily Activities
        Route::get('daily-activities', [DailyActivityController::class, 'index'])->name('daily_activities.index');
        Route::get('daily-activities/pdf', [DailyActivityController::class, 'generatePdf'])->name('daily_activities.pdf');

        // Leave Requests
        Route::get('leave-requests', [LeaveRequestController::class, 'index'])->name('leave_requests.index');
        Route::patch('leave-requests/{leaveRequest}/verify', [LeaveRequestController::class, 'verify'])->name('leave_requests.verify');

        // Tasks Management (Accessible by both roles)
        Route::resource('tasks', TaskController::class);

        // Attendance QR
        Route::get('attendance-qrs', [AttendanceQrController::class, 'index'])->name('attendance_qrs.index');
        Route::post('attendance-qrs/generate', [AttendanceQrController::class, 'generate'])->name('attendance_qrs.generate');

        // Administrator only routes
        Route::middleware('role:administrator')->group(function () {
            // Students (Full Access)
            Route::get('students', [StudentController::class, 'index'])->name('students.index');
            Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
            Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
            Route::post('students', [StudentController::class, 'store'])->name('students.store');
            Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
            Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
            Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

            // Settings
            Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
            Route::post('settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
            Route::post('settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password.update');
        });
    });
});

Route::get('/view-leave-request/{filename}', function ($filename) {
    $path = storage_path('app/public/leave_requests/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('admin.view_leave_file');

