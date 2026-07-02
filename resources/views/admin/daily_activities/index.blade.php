@extends('layouts.admin')
@section('content')

<!-- Page Header -->
<div class="mb-xl">
<h1 class="font-headline-lg text-headline-lg text-primary">Reports &amp; Export</h1>
<p class="font-body-md text-on-surface-variant">Generate final assessment documents and monitor student daily reports.</p>
</div>
<div class="grid grid-cols-12 gap-xl">
<!-- Filter Panel -->
<section class="col-span-12 lg:col-span-4 flex flex-col gap-lg">
<div class="bg-surface-container-lowest p-lg rounded-xl shadow-sm border border-outline-variant ambient-shadow h-fit">
<h2 class="font-headline-md text-headline-md text-primary mb-lg">Report Configuration</h2>
<form method="GET" action="{{ route('admin.daily_activities.index') }}" class="space-y-lg">
<!-- Select Student -->
<div>
<label class="block font-label-md text-on-surface-variant mb-xs">Select Student / Cohort</label>
<select name="student_id" onchange="this.form.submit()" class="w-full border-outline-variant rounded-lg font-body-md focus:border-primary focus:ring-primary">
<option value="all">All Students</option>
@foreach($studentsProgress ?? [] as $student)
<option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
@endforeach
</select>
</div>
<!-- Date Range -->
<div class="grid grid-cols-2 gap-md">
<div>
<label class="block font-label-md text-on-surface-variant mb-xs">Start Date</label>
<input name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()" class="w-full border-outline-variant rounded-lg font-body-md focus:border-primary focus:ring-primary" type="date">
</div>
<div>
<label class="block font-label-md text-on-surface-variant mb-xs">End Date</label>
<input name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()" class="w-full border-outline-variant rounded-lg font-body-md focus:border-primary focus:ring-primary" type="date">
</div>
</div>
<!-- Report Type -->
<div>
<label class="block font-label-md text-on-surface-variant mb-md">Report Type</label>
<div class="space-y-sm">
<label class="flex items-center gap-md group cursor-pointer">
<input name="report_type" value="attendance" onchange="this.form.submit()" {{ request('report_type') == 'attendance' ? 'checked' : '' }} class="rounded-full text-primary focus:ring-primary border-outline-variant" type="radio">
<span class="font-body-md text-on-surface group-hover:text-primary transition-colors">Attendance Log</span>
</label>
<label class="flex items-center gap-md group cursor-pointer">
<input name="report_type" value="daily_activities" onchange="this.form.submit()" {{ request('report_type', 'daily_activities') == 'daily_activities' ? 'checked' : '' }} class="rounded-full text-primary focus:ring-primary border-outline-variant" type="radio">
<span class="font-body-md text-on-surface group-hover:text-primary transition-colors">Daily Activities Log</span>
</label>
<label class="flex items-center gap-md group cursor-pointer">
<input name="report_type" value="final_grade" onchange="this.form.submit()" {{ request('report_type') == 'final_grade' ? 'checked' : '' }} class="rounded-full text-primary focus:ring-primary border-outline-variant" type="radio">
<span class="font-body-md text-on-surface group-hover:text-primary transition-colors">Final Grade Evaluation</span>
</label>
</div>
</div>
<!-- Actions -->
<div class="pt-sm">
<a href="{{ route('admin.daily_activities.pdf', request()->query()) }}" target="_blank" class="w-full bg-primary text-on-primary font-label-lg font-bold py-3 rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 active:shadow-sm transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined">picture_as_pdf</span>
Generate Report (PDF)
</a>
</div>
</form>
</div>
<!-- Export Tip Card -->
<div class="bg-primary-container p-lg rounded-xl text-on-primary-container">
<div class="flex items-center gap-sm mb-sm">
<span class="material-symbols-outlined">info</span>
<h3 class="font-headline-md text-[18px]">Export Tip</h3>
</div>
<p class="font-body-md opacity-90">Generate a 'Final Grade Evaluation' only after all tasks have been marked as complete by the mentor.</p>
</div>
</section>
<!-- Recent Reports Table -->
<section class="col-span-12 lg:col-span-8">
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant ambient-shadow overflow-hidden">
<div class="px-lg py-md border-b border-outline-variant flex justify-between items-center">
<h2 class="font-headline-md text-headline-md text-primary">
    @if($reportType === 'daily_activities')
        Recent Daily Activities
    @elseif($reportType === 'attendance')
        Attendance Log
    @elseif($reportType === 'final_grade')
        Final Grade Evaluation
    @endif
</h2>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left min-w-[800px]">
@if($reportType === 'daily_activities')
<thead class="bg-surface-container-low border-b border-outline-variant">
<tr>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Student</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Date Submitted</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Activity Notes</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Type</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider text-right">Action</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
@forelse($activities as $activity)
<tr class="hover:bg-surface-container transition-colors duration-150">
<td class="px-lg py-md">
<div class="flex items-center gap-md">
<div class="w-8 h-8 rounded bg-primary-fixed-dim flex items-center justify-center text-primary font-bold">
    <img alt="Student" class="w-full h-full object-cover rounded" src="https://ui-avatars.com/api/?name={{ urlencode($activity->student->name ?? 'User') }}&background=EBF4FF&color=1F5E9B"/>
</div>
<div>
<p class="font-body-md font-bold text-on-surface">{{ $activity->student->name ?? 'Unknown' }}</p>
<p class="text-label-md text-outline">{{ $activity->student->major ?? '-' }}</p>
</div>
</div>
</td>
<td class="px-lg py-md font-body-md text-on-surface-variant whitespace-nowrap">{{ \Carbon\Carbon::parse($activity->date)->format('M d, Y') }}</td>
<td class="px-lg py-md font-body-md text-on-surface-variant max-w-xs truncate" title="{{ $activity->description }}">{{ $activity->description }}</td>
<td class="px-lg py-md whitespace-nowrap">
@if($activity->attachment_path)
    <span class="px-sm py-xs bg-error-container text-error font-label-md rounded flex items-center gap-1 w-fit"><span class="material-symbols-outlined text-[14px]">attach_file</span> ATTACHED</span>
@else
    <span class="px-sm py-xs bg-surface-container-highest text-primary font-label-md rounded">TEXT</span>
@endif
</td>
<td class="px-lg py-md text-right whitespace-nowrap">
<button type="button"
    onclick="openActivityModal({
        student_name: '{{ addslashes($activity->student->name ?? 'Unknown') }}',
        student_major: '{{ addslashes($activity->student->major ?? '-') }}',
        date: '{{ \Carbon\Carbon::parse($activity->date)->format('M d, Y') }}',
        description: '{{ addslashes($activity->description) }}',
        attachment: '{{ $activity->attachment_path ? asset('storage/' . $activity->attachment_path) : '' }}'
    })"
    class="p-sm hover:bg-surface-variant rounded-full text-primary transition-all active:scale-90 inline-block"
    title="View Report Details"
>
    <span class="material-symbols-outlined">visibility</span>
</button>
</td>
</tr>
@empty
<tr>
    <td colspan="5" class="px-lg py-8 text-center text-on-surface-variant">Belum ada aktivitas.</td>
</tr>
@endforelse
</tbody>

@elseif($reportType === 'attendance')
<thead class="bg-surface-container-low border-b border-outline-variant">
<tr>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Student Info</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Date</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Status</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Check In</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Notes</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
@forelse($attendancesList as $att)
<tr class="hover:bg-surface-container transition-colors duration-150">
<td class="px-lg py-md">
<div class="flex items-center gap-md">
<div class="w-8 h-8 rounded bg-primary-fixed-dim flex items-center justify-center text-primary font-bold">
    <img alt="Student" class="w-full h-full object-cover rounded" src="https://ui-avatars.com/api/?name={{ urlencode($att->student->name ?? 'User') }}&background=EBF4FF&color=1F5E9B"/>
</div>
<div>
<p class="font-body-md font-bold text-on-surface">{{ $att->student->name ?? 'Unknown' }}</p>
<p class="text-label-md text-outline">{{ $att->student->nim ?? '-' }}</p>
</div>
</div>
</td>
<td class="px-lg py-md font-body-md text-on-surface-variant">{{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}</td>
<td class="px-lg py-md">
    @if($att->status === 'present')
        <span class="px-sm py-xs bg-green-100 text-green-800 font-label-md rounded font-bold uppercase text-[10px]">Present</span>
    @elseif($att->status === 'absent')
        <span class="px-sm py-xs bg-red-100 text-red-800 font-label-md rounded font-bold uppercase text-[10px]">Absent</span>
    @elseif($att->status === 'sick')
        <span class="px-sm py-xs bg-yellow-100 text-yellow-800 font-label-md rounded font-bold uppercase text-[10px]">Sick</span>
    @else
        <span class="px-sm py-xs bg-blue-100 text-blue-800 font-label-md rounded font-bold uppercase text-[10px]">{{ $att->status }}</span>
    @endif
</td>
<td class="px-lg py-md font-body-md text-on-surface-variant">{{ $att->check_in_time ?? '-' }}</td>
<td class="px-lg py-md font-body-md text-on-surface-variant">{{ $att->notes ?? '-' }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="px-lg py-8 text-center text-on-surface-variant">Belum ada data presensi.</td>
</tr>
@endforelse
</tbody>

@elseif($reportType === 'final_grade')
<thead class="bg-surface-container-low border-b border-outline-variant">
<tr>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider">Student Name</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider text-center">Attendance (30%)</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider text-center">Tasks (50%)</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider text-center">Activities (20%)</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider text-center">Final Score</th>
<th class="px-lg py-md font-label-md text-outline uppercase tracking-wider text-center">Grade</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant">
@forelse($studentsGrade as $grade)
<tr class="hover:bg-surface-container transition-colors duration-150">
<td class="px-lg py-md">
<div class="flex items-center gap-md">
<div class="w-8 h-8 rounded bg-primary-fixed-dim flex items-center justify-center text-primary font-bold">
    <img alt="Student" class="w-full h-full object-cover rounded" src="https://ui-avatars.com/api/?name={{ urlencode($grade->student->name) }}&background=EBF4FF&color=1F5E9B"/>
</div>
<div>
<p class="font-body-md font-bold text-on-surface">{{ $grade->student->name }}</p>
<p class="text-label-md text-outline">{{ $grade->student->university ?? '-' }}</p>
</div>
</div>
</td>
<td class="px-lg py-md text-center font-body-md text-on-surface-variant">{{ $grade->att_score }}</td>
<td class="px-lg py-md text-center font-body-md text-on-surface-variant">{{ $grade->task_score }}</td>
<td class="px-lg py-md text-center font-body-md text-on-surface-variant">{{ $grade->act_score }}</td>
<td class="px-lg py-md text-center font-bold text-primary">{{ $grade->final_score }}</td>
<td class="px-lg py-md text-center font-extrabold text-on-surface text-lg">{{ $grade->letter_grade }}</td>
</tr>
@empty
<tr>
    <td colspan="6" class="px-lg py-8 text-center text-on-surface-variant">Belum ada evaluasi nilai.</td>
</tr>
@endforelse
</tbody>
@endif
</table>
</div>
<div class="px-lg py-md bg-surface-container-low flex items-center justify-between">
@php
    $paginator = $reportType === 'daily_activities' ? $activities : ($reportType === 'attendance' ? $attendancesList : $studentsGrade);
@endphp
<p class="text-label-md text-on-surface-variant">Showing {{ $paginator->count() }} items</p>
<div class="flex items-center gap-sm">
    @if(method_exists($paginator, 'hasPages') && $paginator->hasPages())
        {{ $paginator->links('pagination::tailwind') }}
    @else
        <button class="p-2 border border-outline-variant rounded-md hover:bg-white disabled:opacity-30" disabled="">
        <span class="material-symbols-outlined text-[20px]">chevron_left</span>
        </button>
        <button class="w-8 h-8 flex items-center justify-center rounded-md bg-primary text-on-primary font-label-md text-label-md">1</button>
        <button class="p-2 border border-outline-variant rounded-md hover:bg-white disabled:opacity-30" disabled="">
        <span class="material-symbols-outlined text-[20px]">chevron_right</span>
        </button>
    @endif
</div>
</div>
</div>
<!-- Statistics Section -->
<div class="mt-xl grid grid-cols-1 md:grid-cols-2 gap-lg">
<div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant flex items-center gap-lg">
<div class="w-12 h-12 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed-variant">
<span class="material-symbols-outlined">trending_up</span>
</div>
<div>
<p class="text-label-md text-outline">Kehadiran Hari Ini</p>
<p class="text-headline-md font-bold text-on-surface">{{ $attendancePercentage ?? 0 }}%</p>
</div>
</div>
<div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant flex items-center gap-lg">
<div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed-variant">
<span class="material-symbols-outlined">storage</span>
</div>
<div>
<p class="text-label-md text-outline">Laporan Hari Ini</p>
<p class="text-headline-md font-bold text-on-surface">{{ $todayActivitiesCount ?? 0 }} Reports</p>
</div>
</div>
</div>
<!-- View Daily Activity Modal -->
<div id="viewActivityModal" class="fixed inset-0 z-50 flex items-center justify-center p-md bg-on-background/40 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-surface-container-lowest rounded-2xl w-[calc(100%-2rem)] sm:w-full sm:max-w-lg shadow-2xl border border-outline-variant overflow-hidden scale-95 transition-all duration-300">
        <!-- Header -->
        <div class="px-lg py-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
            <h3 class="font-headline-sm text-headline-sm text-primary flex items-center gap-sm">
                <span class="material-symbols-outlined text-[24px]">analytics</span>
                Daily Activity Details
            </h3>
            <button onclick="closeActivityModal()" class="w-8 h-8 rounded-full flex items-center justify-center text-outline hover:bg-surface-container-highest transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>
        <!-- Body -->
        <div class="p-lg space-y-lg">
            <!-- Student profile card -->
            <div class="flex items-center gap-md p-md bg-surface-container-low rounded-xl border border-outline-variant">
                <div class="w-12 h-12 rounded-full bg-primary-fixed-dim flex items-center justify-center text-primary font-extrabold text-lg" id="modalStudentAvatar">
                    <!-- Initials -->
                </div>
                <div>
                    <h4 class="font-title-md font-bold text-on-surface text-[16px]" id="modalStudentName">Student Name</h4>
                    <p class="text-label-md text-outline" id="modalStudentMajor">Major</p>
                </div>
                <div class="ml-auto text-right">
                    <span class="px-sm py-xs bg-primary-container text-primary font-label-sm rounded-full text-[11px] font-bold" id="modalActivityDate">
                        Date
                    </span>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="space-y-xs">
                <label class="block font-label-md text-outline uppercase tracking-wider">Activity Description / Notes</label>
                <div class="p-md bg-surface-container-lowest rounded-xl border border-outline-variant text-on-surface font-body-md whitespace-pre-wrap leading-relaxed max-h-60 overflow-y-auto" id="modalActivityDescription">
                    <!-- Description -->
                </div>
            </div>

            <!-- Attachment Section -->
            <div id="modalAttachmentSection" class="space-y-xs">
                <label class="block font-label-md text-outline uppercase tracking-wider">Attachment</label>
                <div class="flex items-center justify-between p-md bg-surface-container-low rounded-xl border border-outline-variant">
                    <div class="flex items-center gap-sm text-on-surface-variant font-body-md">
                        <span class="material-symbols-outlined text-primary">attach_file</span>
                        <span class="font-medium text-on-surface" id="modalAttachmentName">document.pdf</span>
                    </div>
                    <a id="modalAttachmentLink" href="#" target="_blank" class="px-md py-2 bg-primary text-on-primary font-label-md rounded-xl hover:opacity-90 transition-all active:scale-95 flex items-center gap-xs shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Download
                    </a>
                </div>
            </div>
            <div id="modalNoAttachmentText" class="text-center py-sm text-outline font-body-md italic bg-surface-container-low rounded-xl border border-outline-variant border-dashed">
                No files attached to this activity.
            </div>
        </div>
        <!-- Footer -->
        <div class="px-lg py-md border-t border-outline-variant bg-surface-container-low flex justify-end">
            <button onclick="closeActivityModal()" class="px-lg py-2.5 border border-outline-variant text-on-surface hover:bg-surface-container-highest font-bold text-[14px] rounded-xl transition-all active:scale-95">
                Close
            </button>
        </div>
    </div>
</div>

<script>
    function openActivityModal(data) {
        const modal = document.getElementById('viewActivityModal');
        const contentBox = modal.querySelector('.scale-95');
        
        // Populate fields
        document.getElementById('modalStudentName').textContent = data.student_name;
        document.getElementById('modalStudentMajor').textContent = data.student_major;
        document.getElementById('modalActivityDate').textContent = data.date;
        document.getElementById('modalActivityDescription').textContent = data.description;

        // Avatar Initials
        const nameParts = data.student_name.trim().split(/\s+/);
        let initials = '';
        if (nameParts.length > 0) {
            initials += nameParts[0][0];
            if (nameParts.length > 1) {
                initials += nameParts[nameParts.length - 1][0];
            }
        }
        document.getElementById('modalStudentAvatar').textContent = initials.toUpperCase();

        // Attachment link
        const attachmentSection = document.getElementById('modalAttachmentSection');
        const noAttachmentText = document.getElementById('modalNoAttachmentText');
        const attachmentLink = document.getElementById('modalAttachmentLink');
        const attachmentName = document.getElementById('modalAttachmentName');

        if (data.attachment) {
            attachmentSection.classList.remove('hidden');
            noAttachmentText.classList.add('hidden');
            attachmentLink.href = data.attachment;
            
            // Extract file name
            const fileName = data.attachment.substring(data.attachment.lastIndexOf('/') + 1);
            attachmentName.textContent = fileName.length > 25 ? fileName.substring(0, 22) + '...' : fileName;
        } else {
            attachmentSection.classList.add('hidden');
            noAttachmentText.classList.remove('hidden');
        }

        // Show modal with transition
        modal.classList.remove('opacity-0', 'pointer-events-none');
        setTimeout(() => {
            contentBox.classList.remove('scale-95');
            contentBox.classList.add('scale-100');
        }, 10);
    }

    function closeActivityModal() {
        const modal = document.getElementById('viewActivityModal');
        const contentBox = modal.querySelector('.scale-100');

        if (contentBox) {
            contentBox.classList.remove('scale-100');
            contentBox.classList.add('scale-95');
        }
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 150);
    }
</script>
</section>
</div>
@endsection


