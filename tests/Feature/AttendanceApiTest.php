<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class AttendanceApiTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $secretKey = 'InternSyncSecretKey123';

    protected function setUp(): void
    {
        parent::setUp();

        // Create a student manually
        $this->user = Student::create([
            'nim' => '1234567890_' . uniqid(),
            'name' => 'Test Intern Student',
            'university' => 'Test University',
            'email' => 'student.test_' . uniqid() . '@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    private function generateQrData($type, $timestamp = null)
    {
        $timestamp = $timestamp ?? (time() * 1000);
        $signatureData = $this->user->id . $timestamp . $this->secretKey;
        $signature = md5($signatureData);

        return json_encode([
            'student_id' => $this->user->id,
            'timestamp' => $timestamp,
            'type' => $type,
            'signature' => $signature,
        ]);
    }

    public function test_check_in_with_valid_qr_and_geofence()
    {
        $qrData = $this->generateQrData('check_in');

        // Office coordinates: -6.200000, 106.816666
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/attendances/check-in', [
                'qr_data' => $qrData,
                'latitude' => -6.200000,
                'longitude' => 106.816666,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->user->id,
            'check_in_latitude' => -6.200000,
            'check_in_longitude' => 106.816666,
        ]);
    }

    public function test_check_in_succeeds_outside_geofence()
    {
        $qrData = $this->generateQrData('check_in');

        // Coordinates far away (e.g. -6.3, 106.9)
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/attendances/check-in', [
                'qr_data' => $qrData,
                'latitude' => -6.300000,
                'longitude' => 106.900000,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->user->id,
            'check_in_latitude' => -6.300000,
            'check_in_longitude' => 106.900000,
        ]);
    }

    public function test_check_in_fails_with_invalid_signature()
    {
        $timestamp = time() * 1000;
        // Invalid signature
        $qrData = json_encode([
            'student_id' => $this->user->id,
            'timestamp' => $timestamp,
            'type' => 'check_in',
            'signature' => 'invalid_signature_hash',
        ]);

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/attendances/check-in', [
                'qr_data' => $qrData,
                'latitude' => -6.200000,
                'longitude' => 106.816666,
            ]);

        $response->assertStatus(400)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Tanda tangan QR Code tidak valid (Keamanan dilanggar).');
    }

    public function test_check_in_fails_with_expired_timestamp()
    {
        // Expired timestamp (2 minutes ago)
        $timestamp = (time() - 120) * 1000;
        $qrData = $this->generateQrData('check_in', $timestamp);

        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/attendances/check-in', [
                'qr_data' => $qrData,
                'latitude' => -6.200000,
                'longitude' => 106.816666,
            ]);

        $response->assertStatus(400)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'QR Code sudah kedaluwarsa. Silakan refresh layar absen.');
    }

    public function test_check_out_with_valid_qr_and_geofence()
    {
        // First check in
        $checkInQr = $this->generateQrData('check_in');
        $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/attendances/check-in', [
                'qr_data' => $checkInQr,
                'latitude' => -6.200000,
                'longitude' => 106.816666,
            ]);

        // Then check out
        $checkOutQr = $this->generateQrData('check_out');
        $response = $this->actingAs($this->user, 'sanctum')
            ->postJson('/api/attendances/check-out', [
                'qr_data' => $checkOutQr,
                'latitude' => -6.200000,
                'longitude' => 106.816666,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->user->id,
            'check_out_latitude' => -6.200000,
            'check_out_longitude' => 106.816666,
        ]);
    }
}
