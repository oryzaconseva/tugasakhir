<?php

namespace App\Http\Controllers;

use App\Models\AttendanceQr;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttendanceQrController extends Controller
{
    public function index()
    {
        $latestQr = AttendanceQr::latest()->first();
        $todayScannedCount = \App\Models\Attendance::whereDate('date', now()->toDateString())->count();
        return view('admin.attendance_qrs.index', compact('latestQr', 'todayScannedCount'));
    }

    public function generate(Request $request)
    {
        $qrData = Str::random(32); // Generate a unique token
        $expiresAt = now()->endOfDay(); // Expires at the end of the day by default

        $qr = AttendanceQr::create([
            'qr_data' => $qrData,
            'date' => now()->toDateString(),
            'expires_at' => $expiresAt,
        ]);

        return redirect()->route('admin.attendance_qrs.index')->with('success', 'QR Code generated successfully.');
    }
}
