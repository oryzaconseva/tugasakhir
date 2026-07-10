<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('cohort') && $request->cohort !== 'all') {
            $query->where('major', $request->cohort);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $students = $query->latest()->paginate(10)->withQueryString();
        
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $pendingVerifications = \App\Models\LeaveRequest::where('status', 'pending')->count();
        
        // Ambil daftar jurusan unik untuk dropdown cohort
        $cohorts = Student::select('major')->distinct()->whereNotNull('major')->pluck('major');

        // Check if we need to pre-open edit modal for a student
        $editStudent = null;
        if ($request->filled('edit_id')) {
            $editStudent = Student::find($request->edit_id);
        }

        return view('admin.students.index', compact('students', 'totalStudents', 'activeStudents', 'pendingVerifications', 'cohorts', 'editStudent'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:students',
            'name' => 'required',
            'university' => 'required',
            'major' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'status' => 'required|in:active,inactive,completed',
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM ini sudah terdaftar, gunakan NIM yang berbeda.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'university.required' => 'Asal universitas wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $validated['password'] = Hash::make($request->nim);

        Student::create($validated);
        return redirect()->route('admin.students.index')->with('success', 'Mahasiswa berhasil ditambahkan. Password default adalah NIM masing-masing.');
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:students,nim,' . $student->id,
            'name' => 'required',
            'university' => 'required',
            'major' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'status' => 'required|in:active,inactive,completed',
        ]);

        $student->update($validated);
        return redirect()->route('admin.students.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
