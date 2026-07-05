<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ ucwords(str_replace('_', ' ', $reportType)) }} Report</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { width: 80px; height: auto; margin-bottom: 10px; }
        .title { font-size: 20px; font-weight: bold; margin: 0; text-transform: uppercase; }
        .subtitle { font-size: 14px; color: #666; margin-top: 5px; }
        .info-section { margin-bottom: 30px; width: 100%; border-collapse: collapse; }
        .info-section td { padding: 5px 0; vertical-align: top; }
        .info-label { font-weight: bold; width: 150px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table.data-table th, table.data-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table.data-table th { background-color: #f5f5f5; font-weight: bold; }
        .footer { margin-top: 50px; text-align: right; font-size: 11px; color: #777; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Millennia Logo">
        <h1 class="title">Internship {{ ucwords(str_replace('_', ' ', $reportType)) }}</h1>
        <div class="subtitle">Generated on {{ now()->format('F d, Y h:i A') }}</div>
    </div>

    <table class="info-section">
        <tr>
            <td class="info-label">Student Name</td>
            <td>: {{ $studentName }}</td>
            <td class="info-label">Report Period</td>
            <td>: 
                @if($request->start_date && $request->end_date)
                    {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }} to {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                @elseif($request->start_date)
                    From {{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}
                @elseif($request->end_date)
                    Until {{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}
                @else
                    All Time
                @endif
            </td>
        </tr>
        @if($reportType == 'daily_activities' || $reportType == 'attendance')
        <tr>
            <td class="info-label">Total Days Attended</td>
            <td>: {{ $presentCount }} / {{ $totalAttendances }} ({{ $attendancePercentage }}%)</td>
            @if($reportType == 'daily_activities')
            <td class="info-label">Total Activities</td>
            <td>: {{ $activities->count() }}</td>
            @endif
        </tr>
        @endif
    </table>

    @if($reportType == 'daily_activities')
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Date</th>
                    @if($studentName == 'All Students')
                    <th width="25%">Student Name</th>
                    @endif
                    <th width="55%">Description of Daily Activity</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $index => $activity)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($activity->date)->format('M d, Y') }}</td>
                    @if($studentName == 'All Students')
                    <td>{{ $activity->student->name ?? 'N/A' }}</td>
                    @endif
                    <td>{{ $activity->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $studentName == 'All Students' ? 4 : 3 }}" class="text-center">No activities recorded for this period.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    @elseif($reportType == 'attendance')
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="15%">Date</th>
                    @if($studentName == 'All Students')
                    <th width="20%">Student Name</th>
                    @endif
                    <th width="12%">Status</th>
                    <th width="12%">Check In</th>
                    <th width="12%">Check Out</th>
                    <th width="12%">Duration</th>
                    <th width="12%">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendancesList as $index => $att)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}</td>
                    @if($studentName == 'All Students')
                    <td>{{ $att->student->name ?? 'N/A' }}</td>
                    @endif
                    <td>{{ ucfirst($att->status) }}</td>
                    <td>{{ $att->check_in_time ? \Carbon\Carbon::parse($att->check_in_time)->format('h:i A') : '-' }}</td>
                    <td>{{ $att->check_out_time ? \Carbon\Carbon::parse($att->check_out_time)->format('h:i A') : '-' }}</td>
                    <td>
                        @if($att->check_in_time && $att->check_out_time)
                            @php
                                $checkIn = \Carbon\Carbon::parse($att->check_in_time);
                                $checkOut = \Carbon\Carbon::parse($att->check_out_time);
                                $duration = $checkIn->diff($checkOut);
                                $hours = $duration->h;
                                $minutes = $duration->i;
                                $durationStr = "";
                                if ($hours > 0) {
                                    $durationStr .= "{$hours}j ";
                                }
                                $durationStr .= "{$minutes}m";
                            @endphp
                            {{ $durationStr }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $att->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $studentName == 'All Students' ? 8 : 7 }}" class="text-center">No attendance recorded for this period.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
    @elseif($reportType == 'final_grade')
        <table class="data-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="25%">Student Name</th>
                    <th width="15%" class="text-center">Attendance<br>(30%)</th>
                    <th width="15%" class="text-center">Tasks<br>(50%)</th>
                    <th width="15%" class="text-center">Activities<br>(20%)</th>
                    <th width="15%" class="text-center">Final Score</th>
                    <th width="10%" class="text-center">Grade</th>
                </tr>
            </thead>
            <tbody>
                @forelse($studentsGrade as $index => $grade)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $grade->student->name }}<br><small style="color: #666;">{{ $grade->student->university ?? $grade->student->major ?? 'N/A' }}</small></td>
                    <td class="text-center">{{ $grade->att_score }}</td>
                    <td class="text-center">{{ $grade->task_score }}</td>
                    <td class="text-center">{{ $grade->act_score }}</td>
                    <td class="text-center"><strong>{{ $grade->final_score }}</strong></td>
                    <td class="text-center">
                        <strong style="font-size: 14px;">{{ $grade->letter_grade }}</strong>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No students found for this evaluation.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 20px; font-size: 11px; color: #555;">
            <strong>Grading Scale:</strong> A (≥ 85), B (75-84), C (60-74), D (50-59), E (< 50)
        </div>
    @endif

    <div class="footer">
        * This is a computer-generated document. No signature is required.
    </div>

</body>
</html>
