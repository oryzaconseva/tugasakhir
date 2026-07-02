<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\DailyActivity;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalStudents = Student::count();
        $todayAttendances = Attendance::whereDate('date', today())->count();
        $activeLeaves = \App\Models\LeaveRequest::where('status', 'pending')->count();
        $totalActivities = DailyActivity::count();

        $recentActivities = DailyActivity::with('student')
            ->latest('date')
            ->latest('id')
            ->take(4)
            ->get();
            
        $latestQr = \App\Models\AttendanceQr::latest()->first();

        // Get active interns progress with search support
        $activeInternsQuery = Student::withCount([
            'attendances',
            'attendances as present_count' => function ($query) {
                $query->where('status', 'present');
            },
            'dailyActivities'
        ])->where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->search;
            $activeInternsQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        $activeInterns = $activeInternsQuery->latest()->get();

        return view('admin.dashboard.index', compact(
            'totalStudents', 
            'todayAttendances', 
            'activeLeaves', 
            'totalActivities', 
            'recentActivities',
            'latestQr',
            'activeInterns'
        ));
    }
}
