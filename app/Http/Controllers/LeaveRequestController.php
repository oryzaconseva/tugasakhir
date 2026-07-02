<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leaveRequests = LeaveRequest::with('student')->latest()->paginate(10);
        
        $totalRequests = LeaveRequest::count();
        $pendingCount = LeaveRequest::where('status', 'pending')->count();
        $approvedCount = LeaveRequest::where('status', 'approved')->count();
        $rejectedCount = LeaveRequest::where('status', 'rejected')->count();
        
        $totalResolved = $approvedCount + $rejectedCount;
        $successRate = $totalResolved > 0 ? round(($approvedCount / $totalResolved) * 100) : 0;

        return view('admin.leave_requests.index', compact(
            'leaveRequests', 'totalRequests', 'pendingCount', 'successRate', 'rejectedCount'
        ));
    }

    public function verify(Request $request, LeaveRequest $leaveRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leaveRequest->update(['status' => $validated['status']]);
        return back()->with('success', 'Leave request verified.');
    }
}
