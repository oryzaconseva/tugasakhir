<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyActivity;
use Illuminate\Support\Facades\Storage;

class DailyActivityController extends Controller
{
    public function index(Request $request)
    {
        $activities = DailyActivity::where('student_id', $request->user()->id)
            ->orderBy('date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $activities
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('daily_activities', 'public');
        }

        $activity = DailyActivity::create([
            'student_id' => $request->user()->id,
            'date' => $request->date,
            'description' => $request->description,
            'attachment_path' => $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Aktivitas harian berhasil ditambahkan.',
            'data' => $activity
        ], 201);
    }
}
