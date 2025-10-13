<?php

namespace Database\Seeders;

use App\Models\Bimbingan;
use App\Models\GuruWali;
use App\Models\JenisBimbingan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) KELAS (pastikan ada minimal 2)
        $kelas = [
            ['nama_kelas' => 'X IPA 1', 'tingkat' => 'X'],
            ['nama_kelas' => 'X IPS 1', 'tingkat' => 'X'],
        ];
        foreach ($kelas as $k) {
            Kelas::firstOrCreate(
                ['nama_kelas' => $k['nama_kelas']],
                ['tingkat' => $k['tingkat']]
            );
        }

        // 2) USERS: admin & guru wali
        $admin = User::firstOrCreate(
            ['email' => 'admin@sekolah.com'],
            ['name' => 'Admin Sekolah', 'password' => bcrypt('123456'), 'role' => 'admin']
        );

        $uGuru = User::firstOrCreate(
            ['email' => 'guru@sekolah.com'],
            ['name' => 'Guru Wali A', 'password' => bcrypt('123456'), 'role' => 'guru_wali']
        );

        // 3) GURU WALI (catatan: kolom `nama` bukan `nama_guru`)
        $guru = GuruWali::firstOrCreate(
            ['user_id' => $uGuru->id],
            ['nip' => '19801231xxxx', 'nama' => 'Guru Wali A'] // sesuaikan kolom yg ada
        );

        // 4) SISWA (otomatis tersebar pada kelas)
        if (Siswa::count() < 20) {
            Siswa::factory()->count(20)->create();
        }

        // 5) JENIS BIMBINGAN
        // beberapa environment masih punya kolom 'kode' (NOT NULL). Isi kalau ada.
        $hasKode = Schema::hasColumn('jenis_bimbingans', 'kode');

        $jenisList = [
            ['nama_jenis' => 'Prestasi',       'tipe' => 'positif', 'poin' =>  5],
            ['nama_jenis' => 'Kedisiplinan',   'tipe' => 'negatif', 'poin' => -2],
            ['nama_jenis' => 'Pelanggaran',    'tipe' => 'negatif', 'poin' => -5],
            ['nama_jenis' => 'Konseling Umum', 'tipe' => 'netral',  'poin' =>  0],
        ];

        $jenisIds = [];
        foreach ($jenisList as $j) {
            $payload = [
                'nama_jenis' => $j['nama_jenis'],
                'tipe'       => $j['tipe'],
                'poin'       => $j['poin'],
            ];
            if ($hasKode) {
                $payload['kode'] = Str::slug($j['nama_jenis']); // isi otomatis bila kolom ada
            }

            $row = JenisBimbingan::firstOrCreate(
                ['nama_jenis' => $j['nama_jenis']],
                $payload
            );
            $jenisIds[] = $row->id;
        }

        // 6) BIMBINGAN (data acak 30 entri dalam 6 bulan terakhir)
        if (Bimbingan::count() < 30) {
            $siswaIds = Siswa::pluck('id')->all();

            // kalau kosong, stop lebih awal agar tidak error
            if (empty($siswaIds) || empty($jenisIds)) {
                $this->command->warn('Tidak ada siswa atau jenis bimbingan — skip pembuatan bimbingan.');
                return;
            }

            for ($i = 0; $i < 30; $i++) {
                $tanggal = Carbon::now()->subDays(rand(0, 330))->format('Y-m-d');
                $siswaId = $siswaIds[array_rand($siswaIds)];
                $jenisId = $jenisIds[array_rand($jenisIds)];
                $jenis   = JenisBimbingan::find($jenisId);

                Bimbingan::create([
                    'tanggal'  => $tanggal,
                    'siswa_id' => $siswaId,
                    'guru_id'  => $guru->id,
                    'jenis_id' => $jenisId,
                    'catatan'  => fake()->sentence(8),
                    'poin'     => $jenis?->poin ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Seeder selesai. Admin: admin@sekolah.com / 123456, Guru: guru@sekolah.com / 123456');
    }
}
