<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->input('date', now()->toDateString());

        $query = Attendance::with('student')->whereDate('date', $selectedDate);

        $attendances = $query->latest('check_in_time')->paginate(10)->withQueryString();
        
        $totalRecords = Attendance::whereDate('date', $selectedDate)->count();
        $lateCount = Attendance::whereDate('date', $selectedDate)->whereTime('check_in_time', '>', '08:30:00')->count();
        $onTimeCount = $totalRecords - $lateCount - Attendance::whereDate('date', $selectedDate)->where('status', 'absent')->count();
        $onTimePercent = $totalRecords > 0 ? round(($onTimeCount / $totalRecords) * 100) : 0;
        
        $lastUpdate = Attendance::latest('updated_at')->first()?->updated_at?->format('h:i A \T\o\d\a\y') ?? 'N/A';
        $latestQr = \App\Models\AttendanceQr::latest()->first();

        return view('admin.attendances.index', compact(
            'attendances', 'totalRecords', 'lateCount', 'onTimeCount', 'onTimePercent', 'lastUpdate', 'latestQr', 'selectedDate'
        ));
    }
}
