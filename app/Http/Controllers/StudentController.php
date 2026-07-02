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

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));

        $header = array_shift($data);
        $header = array_map('trim', $header);
        $header = array_map('strtolower', $header);

        $count = 0;
        foreach ($data as $row) {
            if (count($row) === count($header)) {
                $studentData = array_combine($header, array_map('trim', $row));
                
                if (isset($studentData['nim']) && $studentData['nim'] !== '') {
                    \App\Models\Student::updateOrCreate(
                        ['nim' => $studentData['nim']],
                        [
                            'name' => $studentData['name'] ?? 'Unknown',
                            'university' => $studentData['university'] ?? '-',
                            'major' => $studentData['major'] ?? null,
                            'email' => $studentData['email'] ?? null,
                            'phone' => $studentData['phone'] ?? null,
                            'status' => $studentData['status'] ?? 'active',
                            'password' => \Illuminate\Support\Facades\Hash::make('password'),
                        ]
                    );
                    $count++;
                }
            }
        }

        return back()->with('success', "$count students imported successfully.");
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
            'major' => 'nullable|string|unique:students',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'status' => 'required|in:active,inactive,completed',
        ]);

        $validated['password'] = Hash::make($request->nim);

        Student::create($validated);
        return redirect()->route('admin.students.index')->with('success', 'Student created successfully. Password default adalah NIM masing-masing.');
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
        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
