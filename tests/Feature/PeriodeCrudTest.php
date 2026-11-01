<?php

namespace Tests\Feature;

use App\Models\Cycle;
use App\Models\Medication;
use App\Models\Periode;
use App\Models\Reminder;
use App\Models\Symptom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeriodeCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_periode_index_page(): void
    {
        Periode::factory()->create([
            'periode' => 'GANJIL 2026/2027',
            'singkatan' => '261',
            'status' => true,
        ]);

        $response = $this->get(route('periode.index'));

        $response->assertStatus(200);
        $response->assertSee('GANJIL 2026/2027');
        $response->assertSee('261');
        $response->assertSee('Aktif');
    }

    public function test_can_view_create_page(): void
    {
        $response = $this->get(route('periode.create'));

        $response->assertStatus(200);
        $response->assertSee('Tambah Data Periode');
    }

    public function test_can_store_new_periode(): void
    {
        $payload = [
            'periode' => 'GENAP 2026/2027',
            'singkatan' => '262',
            'status' => '1',
        ];

        $response = $this->post(route('periode.store'), $payload);

        $response->assertRedirect(route('periode.index'));
        $response->assertSessionHas('success', 'Periode berhasil ditambahkan.');

        $this->assertDatabaseHas('periode', [
            'periode' => 'GENAP 2026/2027',
            'singkatan' => '262',
            'status' => true,
        ]);
    }

    public function test_store_validation_requires_periode_and_singkatan(): void
    {
        $response = $this->post(route('periode.store'), []);

        $response->assertSessionHasErrors(['periode', 'singkatan']);
    }

    public function test_store_validation_rejects_duplicate_singkatan(): void
    {
        Periode::factory()->create(['singkatan' => '271']);

        $response = $this->post(route('periode.store'), [
            'periode' => 'GANJIL 2027/2028',
            'singkatan' => '271',
        ]);

        $response->assertSessionHasErrors(['singkatan']);
    }

    public function test_can_view_edit_page(): void
    {
        $periode = Periode::factory()->create();

        $response = $this->get(route('periode.edit', $periode));

        $response->assertStatus(200);
        $response->assertSee($periode->periode);
    }

    public function test_can_update_periode_without_changing_singkatan(): void
    {
        $periode = Periode::factory()->create([
            'periode' => 'LAMA 2025/2026',
            'singkatan' => '251',
            'status' => false,
        ]);

        $response = $this->put(route('periode.update', $periode), [
            'periode' => 'BARU 2025/2026',
            'singkatan' => '251',
            'status' => '1',
        ]);

        $response->assertRedirect(route('periode.index'));
        $response->assertSessionHas('success', 'Periode berhasil diubah.');

        $this->assertDatabaseHas('periode', [
            'id' => $periode->id,
            'periode' => 'BARU 2025/2026',
            'status' => true,
        ]);
    }

    public function test_can_delete_periode(): void
    {
        $periode = Periode::factory()->create();

        $response = $this->delete(route('periode.destroy', $periode));

        $response->assertRedirect(route('periode.index'));
        $response->assertSessionHas('success', 'Periode berhasil dihapus.');

        $this->assertDatabaseMissing('periode', [
            'id' => $periode->id,
        ]);
    }

    public function test_can_view_dashboard_page(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Siklus Menstruasi');
        $response->assertSee('Flo Engine');
    }

    public function test_can_view_cycles_index_page(): void
    {
        $user = User::factory()->create();
        Cycle::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('cycles.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Siklus');
    }

    public function test_can_view_symptoms_index_page(): void
    {
        Symptom::factory()->create(['name' => 'Kram Perut']);

        $response = $this->get(route('symptoms.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Gejala');
    }

    public function test_can_view_medications_index_page(): void
    {
        $user = User::factory()->create();
        Medication::factory()->create(['user_id' => $user->id, 'name' => 'Sangobion']);

        $response = $this->get(route('medications.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Obat');
    }

    public function test_can_view_reminders_index_page(): void
    {
        $user = User::factory()->create();
        Reminder::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('reminders.index'));

        $response->assertStatus(200);
        $response->assertSee('Daftar Pengingat');
    }
}
