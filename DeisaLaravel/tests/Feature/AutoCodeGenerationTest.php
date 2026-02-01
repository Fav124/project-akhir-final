<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\SantriSakit;
use App\Models\Obat;
use App\Models\User;

class AutoCodeGenerationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_nis_for_santri()
    {
        // Mock dependencies if needed, or just create minimal data
        $kelas = Kelas::create([
            'nama_kelas' => 'Test Class',
            // kode_kelas auto-generated
        ]);

        $jurusan = Jurusan::create([
            'nama_jurusan' => 'Test Jurusan',
            // kode_jurusan auto-generated
        ]);

        $santri = Santri::create([
            'nama_lengkap' => 'Test Santri',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'jurusan_id' => $jurusan->id,
            // nis auto-generated
        ]);

        $this->assertNotNull($santri->nis);
        $this->assertStringStartsWith(now()->format('ymd'), $santri->nis);
        $this->assertTrue(strlen($santri->nis) >= 9);

        // Test Sequence
        $santri2 = Santri::create([
            'nama_lengkap' => 'Test Santri 2',
            'jenis_kelamin' => 'P',
            'kelas_id' => $kelas->id,
            'jurusan_id' => $jurusan->id,
        ]);

        $this->assertNotNull($santri2->nis);
        $this->assertEquals(intval(substr($santri->nis, -3)) + 1, intval(substr($santri2->nis, -3)));
    }

    /** @test */
    public function it_generates_kode_kelas()
    {
        $kelas = Kelas::create([
            'nama_kelas' => 'Class A',
        ]);

        $this->assertNotNull($kelas->kode_kelas);
        $this->assertStringStartsWith('K-', $kelas->kode_kelas);
        $this->assertEquals('K-0001', $kelas->kode_kelas);

        $kelas2 = Kelas::create([
            'nama_kelas' => 'Class B',
        ]);
        $this->assertEquals('K-0002', $kelas2->kode_kelas);
    }

    /** @test */
    public function it_generates_kode_jurusan()
    {
        $jurusan = Jurusan::create([
            'nama_jurusan' => 'Jurusan A',
        ]);

        $this->assertNotNull($jurusan->kode_jurusan);
        $this->assertStringStartsWith('J-', $jurusan->kode_jurusan);
        $this->assertEquals('J-001', $jurusan->kode_jurusan);

        $jurusan2 = Jurusan::create([
            'nama_jurusan' => 'Jurusan B',
        ]);
        $this->assertEquals('J-002', $jurusan2->kode_jurusan);
    }

    /** @test */
    public function it_generates_kode_obat()
    {
        $obat = Obat::create([
            'nama_obat' => 'Paracetamol',
        ]);

        $this->assertNotNull($obat->kode_obat);
        $this->assertStringStartsWith('OBT-', $obat->kode_obat);
        $this->assertEquals('OBT-001', $obat->kode_obat);

        $obat2 = Obat::create([
            'nama_obat' => 'Ibuprofen',
        ]);
        $this->assertEquals('OBT-002', $obat2->kode_obat);
    }

    /** @test */
    public function it_generates_kode_riwayat_for_santri_sakit()
    {
        // Setup dependencies
        $kelas = Kelas::create(['nama_kelas' => 'C']);
        $jurusan = Jurusan::create(['nama_jurusan' => 'D']);
        $santri = Santri::create([
            'nama_lengkap' => 'S',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'jurusan_id' => $jurusan->id
        ]);

        $sakit = SantriSakit::create([
            'santri_id' => $santri->id,
            'tgl_masuk' => now(),
        ]);

        $this->assertNotNull($sakit->kode_riwayat);
        $this->assertStringStartsWith('RS-' . now()->format('ymd') . '-', $sakit->kode_riwayat);

        $sakit2 = SantriSakit::create([
            'santri_id' => $santri->id,
            'tgl_masuk' => now(),
        ]);

        // Extract sequence
        preg_match('/-(\d+)$/', $sakit->kode_riwayat, $m1);
        preg_match('/-(\d+)$/', $sakit2->kode_riwayat, $m2);

        $this->assertEquals(intval($m1[1]) + 1, intval($m2[1]));
    }
}
