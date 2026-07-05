@extends('layouts.admin')

@section('content')
<div class="space-y-xl">
    <!-- Modern Header Section -->
    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-lg bg-white p-lg rounded-2xl border border-outline-variant/20 shadow-sm">
        <div>
            <h1 class="text-3xl font-black text-primary tracking-tight">Leave Requests</h1>
            <p class="text-sm text-on-surface-variant font-medium mt-1">Manage and verify intern leave requests</p>
        </div>
        
        <div class="grid grid-cols-3 gap-2 sm:flex sm:items-center sm:gap-4 w-full lg:w-auto">
            <div class="bg-surface-container-lowest border border-outline-variant/40 rounded-xl px-3 py-2 sm:px-4 text-center">
                <span class="block text-[10px] sm:text-xs font-bold text-on-surface-variant uppercase tracking-widest">Pending</span>
                <span class="block text-lg sm:text-xl font-black text-secondary">{{ $pendingCount ?? 0 }}</span>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant/40 rounded-xl px-3 py-2 sm:px-4 text-center">
                <span class="block text-[10px] sm:text-xs font-bold text-on-surface-variant uppercase tracking-widest">Resolved</span>
                <span class="block text-lg sm:text-xl font-black text-primary">{{ ($totalRequests ?? 0) - ($pendingCount ?? 0) }}</span>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant/40 rounded-xl px-3 py-2 sm:px-4 text-center">
                <span class="block text-[10px] sm:text-xs font-bold text-on-surface-variant uppercase tracking-widest">Success</span>
                <span class="block text-lg sm:text-xl font-black text-primary">{{ $successRate ?? 0 }}%</span>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col h-full">
        <div class="overflow-x-auto flex-1">
            <table class="w-full text-left border-collapse min-w-[850px]">
                <thead>
                    <tr class="bg-surface-container-low/30 border-b border-outline-variant/10">
                        <th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Student</th>
                        <th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Type</th>
                        <th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Date Range</th>
                        <th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Description</th>
                        <th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Attachment</th>
                        <th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline">Status</th>
                        <th class="px-xl py-4 text-[11px] font-bold uppercase tracking-widest text-outline text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @forelse($leaveRequests as $req)
                    <tr class="hover:bg-surface-container-lowest/50 transition-colors group">
                        <!-- Student -->
                        <td class="px-xl py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                    {{ substr($req->student->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-on-surface">{{ $req->student->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $req->student->nim ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Type -->
                        <td class="px-xl py-4">
                            @if(($req->type ?? 'other') === 'sick')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-rose-50 text-rose-700 text-xs font-semibold border border-rose-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    Sick Leave
                                </span>
                            @elseif(($req->type ?? 'other') === 'personal')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-semibold border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Personal
                                </span>
                            @elseif(($req->type ?? 'other') === 'academic')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-sky-50 text-sky-700 text-xs font-semibold border border-sky-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-500"></span>
                                    Academic
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-slate-50 text-slate-700 text-xs font-semibold border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                    {{ ucfirst($req->type ?? 'Other') }}
                                </span>
                            @endif
                        </td>
                        
                        <!-- Date Range -->
                        <td class="px-xl py-4 text-sm font-semibold text-on-surface-variant">
                            <div class="flex flex-col">
                                <span>{{ \Carbon\Carbon::parse($req->start_date)->format('d M Y') }}</span>
                                <span class="text-xs text-outline font-normal">to {{ \Carbon\Carbon::parse($req->end_date)->format('d M Y') }}</span>
                            </div>
                        </td>
                        
                        <!-- Description -->
                        <td class="px-xl py-4 text-sm text-on-surface-variant max-w-[200px]">
                            <div class="truncate font-medium" title="{{ $req->reason }}">{{ $req->reason }}</div>
                        </td>
                        
                        <!-- Attachment -->
                        <td class="px-xl py-4">
                            @if($req->attachment_path)
                                <a href="{{ route('admin.view_leave_file', basename($req->attachment_path)) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/5 hover:bg-primary hover:text-white border border-primary/20 hover:border-primary rounded-lg text-xs font-bold transition-all active:scale-95 shadow-sm" title="View uploaded document">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    <span>View File</span>
                                </a>
                            @else
                                <span class="text-xs text-outline font-medium">No Attachment</span>
                            @endif
                        </td>
                        
                        <!-- Status -->
                        <td class="px-xl py-4">
                            @if($req->status === 'pending')
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase tracking-wider">Pending</span>
                            @elseif($req->status === 'approved')
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold uppercase tracking-wider">Approved</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold uppercase tracking-wider">Rejected</span>
                            @endif
                        </td>
                        
                        <!-- Action -->
                        <td class="px-xl py-4 text-right">
                            <div class="flex items-center justify-end gap-2 text-right">
                                <!-- Approve button -->
                                @if($req->status === 'approved')
                                    <button type="button" class="flex items-center gap-1.5 px-3 py-1.5 bg-green-600 text-white border border-green-600 rounded-lg text-xs font-semibold cursor-default shadow-sm" disabled>
                                        <span class="material-symbols-outlined text-[16px] font-bold">check</span>
                                        <span>Approved</span>
                                    </button>
                                @else
                                    <form action="{{ route('admin.leave_requests.verify', $req->id) }}" method="POST" class="m-0 p-0 inline" onsubmit="showConfirm(event, 'approved')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-600 hover:text-white border border-green-200 hover:border-green-600 rounded-lg text-xs font-semibold transition-all active:scale-95" title="Approve Request">
                                            <span class="material-symbols-outlined text-[16px]">check</span>
                                            <span>Approve</span>
                                        </button>
                                    </form>
                                @endif

                                <!-- Reject button -->
                                @if($req->status === 'rejected')
                                    <button type="button" class="flex items-center gap-1.5 px-3 py-1.5 bg-red-600 text-white border border-red-600 rounded-lg text-xs font-semibold cursor-default shadow-sm" disabled>
                                        <span class="material-symbols-outlined text-[16px] font-bold">close</span>
                                        <span>Rejected</span>
                                    </button>
                                @else
                                    <form action="{{ route('admin.leave_requests.verify', $req->id) }}" method="POST" class="m-0 p-0 inline" onsubmit="showConfirm(event, 'rejected')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-red-600 hover:text-white border border-rose-200 hover:border-red-600 rounded-lg text-xs font-semibold transition-all active:scale-95" title="Reject Request">
                                            <span class="material-symbols-outlined text-[16px]">close</span>
                                            <span>Reject</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-xl py-8 text-center text-on-surface-variant">
                            <div class="flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-outline mb-2">inbox</span>
                                <p class="text-sm font-medium">No leave requests found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-xl py-4 bg-surface-container-low border-t border-outline-variant/10">
            {{ $leaveRequests->links() ?? '' }}
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/40 backdrop-blur-[2px] transition-all duration-300">
    <div class="bg-white rounded-2xl p-6 shadow-xl border border-outline-variant/30 max-w-sm w-full mx-4 transform scale-95 transition-all duration-300" id="modalCard">
        <div class="flex items-center gap-3 mb-4">
            <div id="modalIconContainer" class="w-10 h-10 rounded-full flex items-center justify-center">
                <span id="modalIcon" class="material-symbols-outlined">help</span>
            </div>
            <h3 id="modalTitle" class="text-lg font-bold text-on-surface">Confirmation</h3>
        </div>
        <p id="modalMessage" class="text-sm text-on-surface-variant font-medium mb-6">Are you sure you want to proceed?</p>
        <div class="flex items-center justify-end gap-3">
            <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 rounded-xl border border-outline-variant/30 text-sm font-semibold text-on-surface-variant hover:bg-surface-container transition-all active:scale-95">
                Batal
            </button>
            <button type="button" id="confirmBtn" class="px-4 py-2 rounded-xl text-sm font-semibold text-white transition-all active:scale-95">
                Ya, Lanjutkan
            </button>
        </div>
    </div>
</div>

<script>
    let pendingFormToSubmit = null;

    function showConfirm(event, status) {
        event.preventDefault();
        pendingFormToSubmit = event.target;
        
        const modal = document.getElementById('confirmModal');
        const modalCard = document.getElementById('modalCard');
        const modalIconContainer = document.getElementById('modalIconContainer');
        const modalIcon = document.getElementById('modalIcon');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('confirmBtn');
        
        if (status === 'approved') {
            modalIconContainer.className = 'w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600';
            modalIcon.textContent = 'check_circle';
            modalTitle.textContent = 'Setujui Permohonan';
            modalMessage.textContent = 'Apakah Anda yakin ingin menyetujui permohonan cuti ini?';
            confirmBtn.className = 'px-4 py-2 rounded-xl text-sm font-semibold text-white bg-green-600 hover:bg-green-700 transition-all active:scale-95';
        } else {
            modalIconContainer.className = 'w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600';
            modalIcon.textContent = 'cancel';
            modalTitle.textContent = 'Tolak Permohonan';
            modalMessage.textContent = 'Apakah Anda yakin ingin menolak permohonan cuti ini?';
            confirmBtn.className = 'px-4 py-2 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition-all active:scale-95';
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modalCard.classList.remove('scale-95');
            modalCard.classList.add('scale-100');
        }, 10);
    }

    function closeConfirmModal() {
        const modal = document.getElementById('confirmModal');
        const modalCard = document.getElementById('modalCard');
        modalCard.classList.remove('scale-100');
        modalCard.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            pendingFormToSubmit = null;
        }, 150);
    }

    document.getElementById('confirmBtn').addEventListener('click', () => {
        if (pendingFormToSubmit) {
            pendingFormToSubmit.submit();
        }
    });
</script>
@endsection