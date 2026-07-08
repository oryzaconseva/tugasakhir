<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Carbon\Carbon;

class MarkAbsentStudents extends Command
{
    /**
     * Nama command yang dipanggil via artisan.
     */
    protected $signature = 'attendance:mark-absent
                            {--date= : Tanggal target (format: Y-m-d). Default: hari ini}
                            {--force : Jalankan meski hari weekend}';

    /**
     * Deskripsi command.
     */
    protected $description = 'Otomatis tandai mahasiswa yang tidak hadir (absent/leave) berdasarkan data absensi dan izin hari ini.';

    public function handle(): int
    {
        // --- 1. Tentukan tanggal target ---
        $targetDate = $this->option('date')
            ? Carbon::parse($this->option('date'))
            : Carbon::today();

        $dateStr = $targetDate->toDateString();
        $dayName = $targetDate->translatedFormat('l'); // Senin, Selasa, dst.

        $this->info("======================================");
        $this->info("  Auto-Mark Absent — InternSync");
        $this->info("======================================");
        $this->line("  Tanggal Target : {$dateStr} ({$dayName})");
        $this->line("");

        // --- 2. Cek hari weekend ---
        if ($targetDate->isWeekend() && !$this->option('force')) {
            $this->warn("  Hari ini adalah hari weekend ({$dayName}). Command dibatalkan.");
            $this->warn("  Gunakan --force untuk memaksa menjalankan di hari weekend.");
            return Command::SUCCESS;
        }

        // --- 3. Ambil semua student aktif ---
        $students = Student::where('status', 'active')->get();

        if ($students->isEmpty()) {
            $this->warn("  Tidak ada student aktif yang ditemukan.");
            return Command::SUCCESS;
        }

        $this->line("  Total student aktif : {$students->count()}");
        $this->line("");

        // --- 4. Proses tiap student ---
        $markedAbsent = 0;
        $markedLeave  = 0;
        $alreadyPresent = 0;
        $skipped = 0;

        foreach ($students as $student) {
            // Cek apakah sudah ada record attendance hari ini
            $existingAttendance = Attendance::where('student_id', $student->id)
                ->whereDate('date', $dateStr)
                ->first();

            if ($existingAttendance) {
                // Sudah ada record (hadir, izin, atau sudah absent) — skip
                $alreadyPresent++;
                $this->line("  ✓ [{$student->name}] Sudah punya record: {$existingAttendance->status}");
                continue;
            }

            // Cek apakah ada Leave Request yang diapprove di hari ini
            $approvedLeave = LeaveRequest::where('student_id', $student->id)
                ->where('status', 'approved')
                ->whereDate('start_date', '<=', $dateStr)
                ->whereDate('end_date', '>=', $dateStr)
                ->first();

            if ($approvedLeave) {
                // Buat record sebagai 'leave'
                Attendance::create([
                    'student_id' => $student->id,
                    'date'       => $dateStr,
                    'status'     => 'leave',
                ]);
                $markedLeave++;
                $this->line("  📋 [{$student->name}] Ditandai sebagai IZIN (ada leave request approved)");
            } else {
                // Tidak hadir, tidak ada izin → ABSENT
                Attendance::create([
                    'student_id' => $student->id,
                    'date'       => $dateStr,
                    'status'     => 'absent',
                ]);
                $markedAbsent++;
                $this->line("  ✗ [{$student->name}] Ditandai sebagai ABSEN");
            }
        }

        // --- 5. Ringkasan ---
        $this->line("");
        $this->info("======================================");
        $this->info("  Selesai! Ringkasan:");
        $this->info("======================================");
        $this->line("  Sudah hadir / ada record : {$alreadyPresent}");
        $this->line("  Ditandai ABSEN            : {$markedAbsent}");
        $this->line("  Ditandai IZIN             : {$markedLeave}");
        $this->line("  Total diproses            : {$students->count()}");
        $this->line("");

        return Command::SUCCESS;
    }
}
