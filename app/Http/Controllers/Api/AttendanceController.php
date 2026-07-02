<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\AttendanceQr;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $attendances = Attendance::where('student_id', $request->user()->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $attendances
        ], 200);
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        $today = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        // Cek apakah QR valid
        $qr = AttendanceQr::where('qr_data', $request->qr_data)
            ->where('date', $today)
            ->where('expires_at', '>=', Carbon::now())
            ->first();

        if (!$qr) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code tidak valid atau sudah kedaluwarsa.'
            ], 400);
        }

        // Cek apakah sudah absen hari ini
        $existingAttendance = Attendance::where('student_id', $request->user()->id)
            ->where('date', $today)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-in hari ini.'
            ], 400);
        }

        $attendance = Attendance::create([
            'student_id' => $request->user()->id,
            'date' => $today,
            'check_in_time' => $currentTime,
            'status' => 'present' // atau status lain sesuai konfigurasi
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil.',
            'data' => $attendance
        ], 201);
    }

    public function checkOut(Request $request)
    {
        $today = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $attendance = Attendance::where('student_id', $request->user()->id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan check-in hari ini.'
            ], 400);
        }

        if ($attendance->check_out_time) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-out hari ini.'
            ], 400);
        }

        $attendance->update([
            'check_out_time' => $currentTime
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out berhasil.',
            'data' => $attendance
        ], 200);
    }
}
