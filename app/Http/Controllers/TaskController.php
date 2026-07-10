<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Task::with('student');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('student', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $tasks = $query->latest('due_date')->paginate(10)->withQueryString();
        $totalTasksCount = Task::count();
        $pendingTasksCount = \App\Models\Task::whereIn('status', ['pending', 'in_progress'])->count();
        
        $studentsProgress = \App\Models\Student::withCount('tasks')
            ->withCount(['tasks as completed_tasks_count' => function ($query) {
                $query->where('status', 'completed');
            }])->get();

        if (method_exists(\App\Models\Student::class, 'scopeActive')) {
            $students = \App\Models\Student::active()->get();
        } else {
            $students = \App\Models\Student::where('status', 'active')->get();
        }

        return view('admin.tasks.index', compact('tasks', 'totalTasksCount', 'pendingTasksCount', 'studentsProgress', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (method_exists(\App\Models\Student::class, 'scopeActive')) {
            $students = \App\Models\Student::active()->get();
        } else {
            $students = \App\Models\Student::where('status', 'active')->get();
        }
        return view('admin.tasks.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'due_date'    => 'required|date',
            'status'      => 'nullable|in:pending,in_progress,completed',
            'priority'    => 'required|in:normal,high,urgent',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'task_file'   => 'nullable|file|mimes:pdf,zip|max:20480',
        ], [
            'title.required'       => 'Judul tugas wajib diisi.',
            'title.max'            => 'Judul tugas maksimal 255 karakter.',
            'description.required' => 'Deskripsi tugas wajib diisi.',
            'due_date.required'    => 'Tanggal tenggat wajib diisi.',
            'due_date.date'        => 'Format tanggal tenggat tidak valid.',
            'priority.required'    => 'Prioritas tugas wajib dipilih.',
            'priority.in'          => 'Prioritas tidak valid.',
            'student_ids.required' => 'Pilih minimal satu mahasiswa penerima tugas.',
            'student_ids.array'    => 'Data mahasiswa tidak valid.',
            'task_file.mimes'      => 'File tugas harus berformat PDF atau ZIP.',
            'task_file.max'        => 'Ukuran file tugas maksimal 20MB.',
        ]);

        $taskFilePath = null;
        if ($request->hasFile('task_file')) {
            $taskFilePath = $request->file('task_file')->store('task_files', 'public');
        }

        foreach ($validated['student_ids'] as $studentId) {
            $task = Task::create([
                'student_id' => $studentId,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'] ?? 'pending',
                'priority' => $validated['priority'],
                'task_file' => $taskFilePath,
            ]);

            \App\Models\AppNotification::create([
                'student_id' => $studentId,
                'title' => 'Tugas Baru',
                'message' => 'Anda mendapatkan tugas baru: ' . $task->title,
                'type' => 'task',
            ]);
        }

        return redirect()->route('admin.tasks.index')->with('success', 'Tugas berhasil diberikan kepada mahasiswa yang dipilih.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::with('student')->findOrFail($id);
        return view('admin.tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'due_date'    => 'required|date',
            'status'      => 'required|in:pending,in_progress,completed',
            'priority'    => 'required|in:normal,high,urgent',
            'task_file'   => 'nullable|file|mimes:pdf,zip|max:20480',
        ], [
            'title.required'       => 'Judul tugas wajib diisi.',
            'title.max'            => 'Judul tugas maksimal 255 karakter.',
            'description.required' => 'Deskripsi tugas wajib diisi.',
            'due_date.required'    => 'Tanggal tenggat wajib diisi.',
            'due_date.date'        => 'Format tanggal tenggat tidak valid.',
            'status.required'      => 'Status tugas wajib dipilih.',
            'priority.required'    => 'Prioritas tugas wajib dipilih.',
            'task_file.mimes'      => 'File tugas harus berformat PDF atau ZIP.',
            'task_file.max'        => 'Ukuran file tugas maksimal 20MB.',
        ]);

        if ($request->hasFile('task_file')) {
            // Delete old file if exists
            if ($task->task_file && \Storage::disk('public')->exists($task->task_file)) {
                \Storage::disk('public')->delete($task->task_file);
            }
            $validated['task_file'] = $request->file('task_file')->store('task_files', 'public');
        }

        $task->update($validated);

        return redirect()->route('admin.tasks.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->route('admin.tasks.index')->with('success', 'Tugas berhasil dihapus.');
    }
}
