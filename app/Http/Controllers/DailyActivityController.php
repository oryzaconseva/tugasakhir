<?php

namespace App\Http\Controllers;

use App\Models\DailyActivity;
use Illuminate\Http\Request;

class DailyActivityController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->input('report_type', 'daily_activities');
        
        $totalStudents = \App\Models\Student::count();
        $todayAttendance = \App\Models\Attendance::whereDate('date', now()->toDateString())->where('status', 'present')->count();
        $attendancePercentage = $totalStudents > 0 ? round(($todayAttendance / $totalStudents) * 100) : 0;
        
        $todayActivitiesCount = DailyActivity::whereDate('date', now()->toDateString())->count();
        
        $studentsProgress = \App\Models\Student::withCount('dailyActivities')->get();

        // Setup base query for filtering
        $applyFilters = function($query) use ($request) {
            if ($request->filled('student_id') && $request->student_id !== 'all') {
                $query->where('student_id', $request->student_id);
            }
            if ($request->filled('start_date')) {
                $query->whereDate('date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('date', '<=', $request->end_date);
            }
            return $query;
        };

        $activities = collect();
        $attendancesList = collect();
        $studentsGrade = collect();

        if ($reportType == 'daily_activities') {
            $query = DailyActivity::with('student');
            $activities = $applyFilters($query)->latest('date')->paginate(10)->withQueryString();
        } elseif ($reportType == 'attendance') {
            $query = \App\Models\Attendance::with('student');
            $attendancesList = $applyFilters($query)->latest('date')->paginate(10)->withQueryString();
        } elseif ($reportType == 'final_grade') {
            // Get students based on filter (either one or all)
            $studentQuery = \App\Models\Student::query();
            if ($request->filled('student_id') && $request->student_id !== 'all') {
                $studentQuery->where('id', $request->student_id);
            }
            
            $students = $studentQuery->get();
            
            foreach ($students as $student) {
                // 1. Attendance Rate (30%)
                $totalAtt = \App\Models\Attendance::where('student_id', $student->id)->count();
                $present = \App\Models\Attendance::where('student_id', $student->id)->where('status', 'present')->count();
                $attScore = $totalAtt > 0 ? ($present / $totalAtt) * 100 : 0;
                
                // 2. Task Completion (50%)
                $totalTasks = \App\Models\Task::where('student_id', $student->id)->count();
                $completedTasks = \App\Models\Task::where('student_id', $student->id)->where('status', 'completed')->count();
                $taskScore = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                
                // 3. Daily Activities (20%)
                $activitiesCount = \App\Models\DailyActivity::where('student_id', $student->id)->count();
                $actScore = $present > 0 ? min(100, ($activitiesCount / $present) * 100) : 0;
                
                $finalScore = ($attScore * 0.3) + ($taskScore * 0.5) + ($actScore * 0.2);
                
                // Determine Letter Grade
                $letter = 'E';
                if ($finalScore >= 85) $letter = 'A';
                else if ($finalScore >= 75) $letter = 'B';
                else if ($finalScore >= 60) $letter = 'C';
                else if ($finalScore >= 50) $letter = 'D';
                
                $studentsGrade->push((object)[
                    'student' => $student,
                    'att_score' => round($attScore),
                    'task_score' => round($taskScore),
                    'act_score' => round($actScore),
                    'final_score' => round($finalScore, 2),
                    'letter_grade' => $letter
                ]);
            }

            // Paginate manually
            $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10;
            $currentItems = $studentsGrade->slice(($currentPage - 1) * $perPage, $perPage)->all();
            $studentsGrade = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $studentsGrade->count(), $perPage, $currentPage, [
                'path' => \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query()
            ]);
        }

        return view('admin.daily_activities.index', compact(
            'reportType', 'activities', 'attendancesList', 'studentsGrade',
            'attendancePercentage', 'todayActivitiesCount', 'studentsProgress'
        ));
    }

    public function generatePdf(Request $request)
    {
        $reportType = $request->input('report_type', 'daily_activities');
        
        $studentName = 'All Students';
        if ($request->filled('student_id') && $request->student_id !== 'all') {
            $studentName = \App\Models\Student::find($request->student_id)?->name ?? 'Unknown Student';
        }
        
        // Base variables
        $activities = collect();
        $attendancesList = collect();
        $studentsGrade = collect();
        $totalAttendances = 0;
        $presentCount = 0;
        $attendancePercentage = 0;
        
        // Setup base query for filtering
        $applyFilters = function($query) use ($request) {
            if ($request->filled('student_id') && $request->student_id !== 'all') {
                $query->where('student_id', $request->student_id);
            }
            if ($request->filled('start_date')) {
                $query->whereDate('date', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $query->whereDate('date', '<=', $request->end_date);
            }
            return $query;
        };

        if ($reportType == 'daily_activities') {
            $query = DailyActivity::with('student');
            $activities = $applyFilters($query)->orderBy('date', 'asc')->get();
            
            $attendanceQuery = \App\Models\Attendance::query();
            $applyFilters($attendanceQuery);
            $totalAttendances = $attendanceQuery->count();
            $presentCount = (clone $attendanceQuery)->where('status', 'present')->count();
            $attendancePercentage = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100) : 0;
            
        } elseif ($reportType == 'attendance') {
            $query = \App\Models\Attendance::with('student');
            $attendancesList = $applyFilters($query)->orderBy('date', 'asc')->get();
            
            $totalAttendances = $attendancesList->count();
            $presentCount = $attendancesList->where('status', 'present')->count();
            $attendancePercentage = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100) : 0;
            
        } elseif ($reportType == 'final_grade') {
            // Get students based on filter (either one or all)
            $studentQuery = \App\Models\Student::query();
            if ($request->filled('student_id') && $request->student_id !== 'all') {
                $studentQuery->where('id', $request->student_id);
            }
            
            $students = $studentQuery->get();
            
            foreach ($students as $student) {
                // 1. Attendance Rate (30%)
                $totalAtt = \App\Models\Attendance::where('student_id', $student->id)->count();
                $present = \App\Models\Attendance::where('student_id', $student->id)->where('status', 'present')->count();
                $attScore = $totalAtt > 0 ? ($present / $totalAtt) * 100 : 0;
                
                // 2. Task Completion (50%)
                $totalTasks = \App\Models\Task::where('student_id', $student->id)->count();
                $completedTasks = \App\Models\Task::where('student_id', $student->id)->where('status', 'completed')->count();
                $taskScore = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                
                // 3. Daily Activities (20%)
                $activitiesCount = \App\Models\DailyActivity::where('student_id', $student->id)->count();
                $actScore = $present > 0 ? min(100, ($activitiesCount / $present) * 100) : 0;
                
                $finalScore = ($attScore * 0.3) + ($taskScore * 0.5) + ($actScore * 0.2);
                
                // Determine Letter Grade
                $letter = 'E';
                if ($finalScore >= 85) $letter = 'A';
                else if ($finalScore >= 75) $letter = 'B';
                else if ($finalScore >= 60) $letter = 'C';
                else if ($finalScore >= 50) $letter = 'D';
                
                $studentsGrade->push((object)[
                    'student' => $student,
                    'att_score' => round($attScore),
                    'task_score' => round($taskScore),
                    'act_score' => round($actScore),
                    'final_score' => round($finalScore, 2),
                    'letter_grade' => $letter
                ]);
            }
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.daily_activities.pdf', compact(
            'reportType', 'activities', 'attendancesList', 'studentsGrade',
            'studentName', 'request', 'totalAttendances', 'presentCount', 'attendancePercentage'
        ));

        // Format filename
        $dateStr = ($request->start_date && $request->end_date) 
                    ? "{$request->start_date}_to_{$request->end_date}" 
                    : date('Ymd');
        $fileName = "{$reportType}_report_{$dateStr}.pdf";

        return $pdf->download($fileName);
    }
}
