<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\GuruWali;
use App\Models\JenisBimbingan;
use App\Models\Bimbingan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- 1) KELAS ----------
        Kelas::query()->updateOrCreate(
            ['nama_kelas' => 'X IPA 1'],
            ['tingkat' => 'X']
        );
        Kelas::query()->updateOrCreate(
            ['nama_kelas' => 'X IPS 1'],
            ['tingkat' => 'X']
        );

        $kelasIds = Kelas::pluck('id')->toArray();

        // ---------- 2) USERS ----------
        $admin = User::updateOrCreate(
            ['email' => 'admin@sekolah.com'],
            ['name' => 'Admin Sekolah', 'password' => bcrypt('123456'), 'role' => 'admin']
        );

        $guruUser = User::updateOrCreate(
            ['email' => 'guru@sekolah.com'],
            ['name' => 'Guru Wali A', 'password' => bcrypt('123456'), 'role' => 'guru_wali']
        );

        // ---------- 3) GURU WALI ----------
        $guru = GuruWali::updateOrCreate(
            ['user_id' => $guruUser->id],
            ['nip' => '19801231xxxx', 'nama' => 'Guru Wali A']
        );

        // ---------- 4) SISWA (20 data acak) ----------
        if (Siswa::count() < 20) {
            // Pastikan ada kelas untuk relasi
            for ($i = 0; $i < 20; $i++) {
                Siswa::create([
                    'nis'          => (string) fake()->unique()->numerify('20########'),
                    'nama_siswa'   => fake()->name(),
                    'kelas_id'     => $kelasIds[array_rand($kelasIds)],
                    'jk'           => fake()->randomElement(['L','P']),
                    'tanggal_lahir'=> fake()->date(),
                ]);
            }
        }

        // ---------- 5) JENIS BIMBINGAN ----------
        $prestasi = JenisBimbingan::firstOrCreate(
            ['kode' => 'prestasi'],                      // <-- pakai kode sebagai key unik
            ['nama_jenis' => 'Prestasi', 'tipe' => 'positif', 'poin' => 5]
        );

        $pelanggaran = JenisBimbingan::firstOrCreate(
            ['kode' => 'pelanggaran'],
            ['nama_jenis' => 'Pelanggaran', 'tipe' => 'negatif', 'poin' => -2]
        );

        // ---------- 6) BIMBINGAN CONTOH (acak) ----------
        if (Bimbingan::count() === 0) {
            $jenisMap = [$prestasi->id => $prestasi->poin, $pelanggaran->id => $pelanggaran->poin];
            Siswa::inRandomOrder()->take(15)->get()->each(function ($siswa) use ($guru, $jenisMap) {
                $jenisId = array_rand($jenisMap);
                Bimbingan::create([
                    'tanggal'  => now()->subDays(rand(0, 60))->toDateString(),
                    'siswa_id' => $siswa->id,
                    'guru_id'  => $guru->id,
                    'jenis_id' => $jenisId,
                    'catatan'  => fake()->sentence(8),
                    'poin'     => $jenisMap[$jenisId],
                ]);
            });
        }
    }
}
