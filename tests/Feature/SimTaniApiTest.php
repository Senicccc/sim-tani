<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\JenisPekerjaan;
use App\Models\Kegiatan;
use App\Models\KegiatanPekerjaan;
use App\Models\AnggotaJenisPekerjaan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SimTaniApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_and_fetch_profile(): void
    {
        $admin = User::factory()->create([
            'nomor_anggota' => 'ADM001',
            'nama_lengkap' => 'Admin SimTani',
            'email' => 'admin@simtani.test',
            'role' => 'admin',
            'status_aktif' => true,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'identifier' => 'admin@simtani.test',
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonPath('success', true);
        $this->assertNotNull($response->json('data.token'));

        Sanctum::actingAs($admin, ['*']);
        $profile = $this->getJson('/api/auth/me');
        $profile->assertOk();
        $profile->assertJsonPath('data.role', 'admin');
    }

    public function test_member_cannot_access_admin_endpoint(): void
    {
        $member = User::factory()->create([
            'nomor_anggota' => 'AGT001',
            'role' => 'anggota',
            'status_aktif' => true,
        ]);

        Sanctum::actingAs($member, ['*']);

        $this->getJson('/api/users')->assertStatus(403);
    }

    public function test_admin_can_create_job_type_and_activity(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status_aktif' => true]);
        Sanctum::actingAs($admin, ['*']);

        $jobType = $this->postJson('/api/job-types', [
            'nama_pekerjaan' => 'Penanaman',
            'deskripsi' => 'Pekerjaan tanam',
            'satuan' => 'hari',
            'tarif_default' => 150000,
        ]);

        $jobType->assertStatus(201);

        $activity = $this->postJson('/api/activities', [
            'nama_kegiatan' => 'Panen Musim',
            'deskripsi' => 'Kegiatan panen',
            'lokasi' => 'Lahan Desa',
            'tanggal_mulai' => '2026-10-01',
            'tanggal_selesai' => '2026-10-03',
            'status' => 'draft',
            'metode_penjadwalan' => 'manual',
        ]);

        $activity->assertStatus(201);
        $this->assertDatabaseHas('jenis_pekerjaan', ['nama_pekerjaan' => 'Penanaman']);
    }

    public function test_auto_scheduler_assigns_eligible_members_only(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status_aktif' => true]);
        $member1 = User::factory()->create(['role' => 'anggota', 'status_aktif' => true, 'nomor_anggota' => 'AGT010']);
        $member2 = User::factory()->create(['role' => 'anggota', 'status_aktif' => true, 'nomor_anggota' => 'AGT011']);
        $member3 = User::factory()->create(['role' => 'anggota', 'status_aktif' => true, 'nomor_anggota' => 'AGT012']);

        $job = JenisPekerjaan::factory()->create(['nama_pekerjaan' => 'Pemupukan', 'satuan' => 'hari']);
        foreach ([$member1, $member2, $member3] as $member) {
            AnggotaJenisPekerjaan::create([
                'anggota_id' => $member->id,
                'jenis_pekerjaan_id' => $job->id,
                'tingkat_kemampuan' => 'pemula',
            ]);
        }

        $activity = Kegiatan::create([
            'nama_kegiatan' => 'Aktivitas Uji Jadwal',
            'tanggal_mulai' => '2026-10-05',
            'tanggal_selesai' => '2026-10-06',
            'status' => 'draft',
            'metode_penjadwalan' => 'manual',
            'created_by' => $admin->id,
        ]);

        KegiatanPekerjaan::create([
            'kegiatan_id' => $activity->id,
            'jenis_pekerjaan_id' => $job->id,
            'jumlah_orang_dibutuhkan' => 2,
            'jumlah_satuan' => 1,
            'tarif_per_satuan' => 150000,
            'tingkat_kemampuan_minimal' => 'pemula',
        ]);

        Sanctum::actingAs($admin, ['*']);
        $response = $this->postJson('/api/activities/'.$activity->id.'/generate-schedule');

        $response->assertOk();
        $response->assertJsonPath('data.number_assigned', 2);
        $this->assertDatabaseCount('penugasan', 2);
    }

    public function test_member_can_submit_completion_and_admin_can_verify(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'status_aktif' => true]);
        $member = User::factory()->create(['role' => 'anggota', 'status_aktif' => true, 'nomor_anggota' => 'AGT020']);
        $job = JenisPekerjaan::factory()->create(['nama_pekerjaan' => 'Pembersihan Lahan', 'satuan' => 'hari']);
        AnggotaJenisPekerjaan::create([
            'anggota_id' => $member->id,
            'jenis_pekerjaan_id' => $job->id,
            'tingkat_kemampuan' => 'menengah',
        ]);
        $activity = Kegiatan::create([
            'nama_kegiatan' => 'Kegiatan Verifikasi',
            'tanggal_mulai' => '2026-11-01',
            'tanggal_selesai' => '2026-11-02',
            'status' => 'draft',
            'metode_penjadwalan' => 'manual',
            'created_by' => $admin->id,
        ]);
        $requirement = KegiatanPekerjaan::create([
            'kegiatan_id' => $activity->id,
            'jenis_pekerjaan_id' => $job->id,
            'jumlah_orang_dibutuhkan' => 1,
            'jumlah_satuan' => 1,
            'tarif_per_satuan' => 200000,
            'tingkat_kemampuan_minimal' => 'pemula',
        ]);
        $assignment = $requirement->assignments()->create([
            'anggota_id' => $member->id,
            'status' => 'assigned',
            'sumber_penugasan' => 'manual',
            'assigned_at' => now(),
        ]);

        Sanctum::actingAs($member, ['*']);
        $this->postJson('/api/my/tasks/'.$assignment->id.'/complete', [
            'catatan_penyelesaian' => 'Selesai membantu panen',
        ])->assertOk();

        $this->assertDatabaseHas('penugasan', ['id' => $assignment->id, 'status' => 'waiting_verification']);

        Sanctum::actingAs($admin, ['*']);
        $this->postJson('/api/assignments/'.$assignment->id.'/verify', [
            'status' => 'completed',
            'catatan_verifikasi' => 'Tervalidasi',
        ])->assertOk();

        $this->assertDatabaseHas('penugasan', ['id' => $assignment->id, 'status' => 'completed']);
    }
}