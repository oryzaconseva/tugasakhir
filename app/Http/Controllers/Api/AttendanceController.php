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
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $qrData = json_decode($request->qr_data, true);
        if (!$qrData || !isset($qrData['student_id'], $qrData['timestamp'], $qrData['signature'], $qrData['type'])) {
            return response()->json([
                'success' => false,
                'message' => 'Format QR Code tidak valid.'
            ], 400);
        }

        // Verifikasi kepemilikan token QR
        if ($qrData['student_id'] != $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code ini bukan milik Anda.'
            ], 400);
        }

        // Verifikasi tipe token
        if ($qrData['type'] !== 'check_in') {
            return response()->json([
                'success' => false,
                'message' => 'Tipe QR Code tidak valid untuk Check-in.'
            ], 400);
        }

        // Verifikasi signature token
        $expectedSignature = md5($qrData['student_id'] . $qrData['timestamp'] . env('QR_SECRET_KEY', 'InternSyncSecretKey123'));
        if ($qrData['signature'] !== $expectedSignature) {
            return response()->json([
                'success' => false,
                'message' => 'Tanda tangan QR Code tidak valid (Keamanan dilanggar).'
            ], 400);
        }

        // Verifikasi batas waktu token (60 detik)
        $qrTimestamp = (int)($qrData['timestamp'] / 1000); // Milidetik ke Detik
        $serverTime = time();
        if (abs($serverTime - $qrTimestamp) > 60) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code sudah kedaluwarsa. Silakan refresh layar absen.'
            ], 400);
        }

        // Verifikasi lokasi GPS (Geofencing)
        $officeLat = (double)env('OFFICE_LATITUDE', -6.200000);
        $officeLng = (double)env('OFFICE_LONGITUDE', 106.816666);
        $officeRadius = (double)env('OFFICE_RADIUS_METERS', 50);

        $earthRadius = 6371000; // Dalam meter
        $latDelta = deg2rad($request->latitude - $officeLat);
        $lngDelta = deg2rad($request->longitude - $officeLng);
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($request->latitude)) * cos(deg2rad($officeLat)) *
             sin($lngDelta / 2) * sin($lngDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        // if ($distance > $officeRadius) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Absensi ditolak. Anda berada di luar radius kantor (' . round($distance) . ' meter).'
        //     ], 400);
        // }

        // Proses pencatatan absensi
        $today = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $existingAttendance = Attendance::where('student_id', $request->user()->id)
            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan check-in hari ini.'
            ], 400);
        }

        // Tentukan keterlambatan (Batas jam 08:00)
        $isLate = false;
        if (Carbon::now()->format('H:i:s') > '08:00:00') {
            $isLate = true;
        }

        $attendance = Attendance::create([
            'student_id' => $request->user()->id,
            'date' => $today,
            'check_in_time' => $currentTime,
            'check_in_latitude' => $request->latitude,
            'check_in_longitude' => $request->longitude,
            'status' => 'present',
            'is_late' => $isLate
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil.' . ($isLate ? ' Anda terlambat.' : ''),
            'data' => $attendance
        ], 201);
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $qrData = json_decode($request->qr_data, true);
        if (!$qrData || !isset($qrData['student_id'], $qrData['timestamp'], $qrData['signature'], $qrData['type'])) {
            return response()->json([
                'success' => false,
                'message' => 'Format QR Code tidak valid.'
            ], 400);
        }

        // Verifikasi kepemilikan token QR
        if ($qrData['student_id'] != $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code ini bukan milik Anda.'
            ], 400);
        }

        // Verifikasi tipe token
        if ($qrData['type'] !== 'check_out') {
            return response()->json([
                'success' => false,
                'message' => 'Tipe QR Code tidak valid untuk Check-out.'
            ], 400);
        }

        // Verifikasi signature token
        $expectedSignature = md5($qrData['student_id'] . $qrData['timestamp'] . env('QR_SECRET_KEY', 'InternSyncSecretKey123'));
        if ($qrData['signature'] !== $expectedSignature) {
            return response()->json([
                'success' => false,
                'message' => 'Tanda tangan QR Code tidak valid (Keamanan dilanggar).'
            ], 400);
        }

        // Verifikasi batas waktu token (60 detik)
        $qrTimestamp = (int)($qrData['timestamp'] / 1000); // Milidetik ke Detik
        $serverTime = time();
        if (abs($serverTime - $qrTimestamp) > 60) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code sudah kedaluwarsa. Silakan refresh layar absen.'
            ], 400);
        }

        // Verifikasi lokasi GPS (Geofencing)
        $officeLat = (double)env('OFFICE_LATITUDE', -6.200000);
        $officeLng = (double)env('OFFICE_LONGITUDE', 106.816666);
        $officeRadius = (double)env('OFFICE_RADIUS_METERS', 50);

        $earthRadius = 6371000; // Dalam meter
        $latDelta = deg2rad($request->latitude - $officeLat);
        $lngDelta = deg2rad($request->longitude - $officeLng);
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($request->latitude)) * cos(deg2rad($officeLat)) *
             sin($lngDelta / 2) * sin($lngDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        // if ($distance > $officeRadius) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Absensi ditolak. Anda berada di luar radius kantor (' . round($distance) . ' meter).'
        //     ], 400);
        // }

        $today = Carbon::now()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        $attendance = Attendance::where('student_id', $request->user()->id)
            ->whereDate('date', $today)
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

        // Tentukan pulang cepat (Batas jam 17:00)
        $isEarlyCheckout = false;
        if (Carbon::now()->format('H:i:s') < '17:00:00') {
            $isEarlyCheckout = true;
        }

        $attendance->update([
            'check_out_time' => $currentTime,
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
            'is_early_checkout' => $isEarlyCheckout
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Check-out berhasil.' . ($isEarlyCheckout ? ' Anda pulang lebih awal.' : ''),
            'data' => $attendance
        ], 200);
    }
}
