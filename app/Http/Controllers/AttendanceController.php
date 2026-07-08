<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    /**
     * Tandai siswa yang belum hadir hari ini sebagai absent/leave secara manual.
     * Berguna untuk admin tanpa harus menunggu scheduler otomatis.
     */
    public function markAbsent(Request $request)
    {
        $targetDate = $request->input('date', Carbon::today()->toDateString());
        $targetCarbon = Carbon::parse($targetDate);

        $students = Student::where('status', 'active')->get();

        $markedAbsent = 0;
        $markedLeave  = 0;

        foreach ($students as $student) {
            // Skip jika sudah ada record hari ini
            $exists = Attendance::where('student_id', $student->id)
                ->whereDate('date', $targetDate)
                ->exists();

            if ($exists) continue;

            // Cek leave request approved yang mencakup tanggal ini
            $approvedLeave = LeaveRequest::where('student_id', $student->id)
                ->where('status', 'approved')
                ->whereDate('start_date', '<=', $targetDate)
                ->whereDate('end_date', '>=', $targetDate)
                ->first();

            if ($approvedLeave) {
                Attendance::create([
                    'student_id' => $student->id,
                    'date'       => $targetDate,
                    'status'     => 'leave',
                ]);
                $markedLeave++;
            } else {
                Attendance::create([
                    'student_id' => $student->id,
                    'date'       => $targetDate,
                    'status'     => 'absent',
                ]);
                $markedAbsent++;
            }
        }

        $total = $markedAbsent + $markedLeave;

        return redirect()->route('admin.attendances.index', ['date' => $targetDate])
            ->with('success', "Berhasil memproses {$total} mahasiswa: {$markedAbsent} ditandai Absen, {$markedLeave} ditandai Izin.");
    }
}

