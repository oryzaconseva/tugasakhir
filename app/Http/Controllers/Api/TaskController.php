<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::where('student_id', $request->user()->id)
            ->orderBy('due_date', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ], 200);
    }

    public function show(Request $request, $id)
    {
        $task = Task::where('student_id', $request->user()->id)->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $task
        ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,in_progress,completed',
            'progress_notes' => 'nullable|string',
            'task_proof' => 'nullable|file|mimes:pdf,zip,jpg,jpeg,png,xls,xlsx,doc,docx|max:20480'
        ]);

        $task = Task::where('student_id', $request->user()->id)->find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Tugas tidak ditemukan.'
            ], 404);
        }

        $data = [
            'status' => $request->status,
            'progress_notes' => $request->progress_notes
        ];

        if ($request->hasFile('task_proof')) {
            // Delete old proof if it exists
            if ($task->task_proof && \Illuminate\Support\Facades\Storage::disk('public')->exists($task->task_proof)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($task->task_proof);
            }
            $filePath = $request->file('task_proof')->store('task_proofs', 'public');
            $data['task_proof'] = $filePath;
        }

        $task->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Status tugas berhasil diperbarui.',
            'data' => $task
        ], 200);
    }
}
