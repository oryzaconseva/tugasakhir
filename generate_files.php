<?php

$dir = __DIR__;

// Migrations
$migrations = [
    '2026_04_22_024501_create_attendances_table.php' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('attendances', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('student_id')->constrained()->onDelete('cascade');
            \$table->date('date');
            \$table->time('check_in_time')->nullable();
            \$table->time('check_out_time')->nullable();
            \$table->enum('status', ['present', 'absent', 'leave'])->default('present');
            \$table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('attendances');
    }
};
PHP,
    '2026_04_22_024502_create_daily_activities_table.php' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('daily_activities', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('student_id')->constrained()->onDelete('cascade');
            \$table->date('date');
            \$table->text('description');
            \$table->string('attachment_path')->nullable();
            \$table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('daily_activities');
    }
};
PHP,
    '2026_04_22_024503_create_leave_requests_table.php' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('leave_requests', function (Blueprint \$table) {
            \$table->id();
            \$table->foreignId('student_id')->constrained()->onDelete('cascade');
            \$table->date('start_date');
            \$table->date('end_date');
            \$table->text('reason');
            \$table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            \$table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('leave_requests');
    }
};
PHP,
    '2026_04_22_024504_create_attendance_qrs_table.php' => <<<PHP
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('attendance_qrs', function (Blueprint \$table) {
            \$table->id();
            \$table->string('qr_data')->unique();
            \$table->date('date');
            \$table->dateTime('expires_at');
            \$table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('attendance_qrs');
    }
};
PHP,
];

foreach ($migrations as $file => $content) {
    file_put_contents(\$dir . "/database/migrations/" . $file, $content);
}

// Models
$models = [
    'Attendance.php' => <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Attendance extends Model {
    use HasFactory;
    protected \$fillable = ['student_id', 'date', 'check_in_time', 'check_out_time', 'status'];
    public function student() { return \$this->belongsTo(Student::class); }
}
PHP,
    'DailyActivity.php' => <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DailyActivity extends Model {
    use HasFactory;
    protected \$fillable = ['student_id', 'date', 'description', 'attachment_path'];
    public function student() { return \$this->belongsTo(Student::class); }
}
PHP,
    'LeaveRequest.php' => <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class LeaveRequest extends Model {
    use HasFactory;
    protected \$fillable = ['student_id', 'start_date', 'end_date', 'reason', 'status'];
    public function student() { return \$this->belongsTo(Student::class); }
}
PHP,
    'AttendanceQr.php' => <<<PHP
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class AttendanceQr extends Model {
    use HasFactory;
    protected \$fillable = ['qr_data', 'date', 'expires_at'];
}
PHP,
];

foreach ($models as $file => $content) {
    file_put_contents(\$dir . "/app/Models/" . $file, $content);
}

echo "Files generated!\n";
