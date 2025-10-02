<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\GuruWali;
use App\Models\Bimbingan;
use App\Models\JenisBimbingan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kelas
        Kelas::query()->truncate();
        Kelas::factory()->count(2)->sequence(
            ['nama_kelas'=>'X IPA 1','tingkat'=>'X'],
            ['nama_kelas'=>'X IPS 1','tingkat'=>'X'],
        )->create();

        // Users
        User::query()->truncate();
        $admin = User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@sekolah.com',
            'role'     => 'admin',
            'password' => bcrypt('123456'),
        ]);
        $uGuru = User::factory()->create([
            'name'     => 'Guru Wali A',
            'email'    => 'guru@sekolah.com',
            'role'     => 'guru_wali',
            'password' => bcrypt('123456'),
        ]);

        // Guru Wali
        GuruWali::query()->truncate();
        $guru  = GuruWali::create([
            'user_id' => $uGuru->id,
            'nip'     => '1980xxxx',
            'nama'    => 'Guru Wali A',
        ]);

        // Siswa
        Siswa::query()->truncate();
        Siswa::factory()->count(40)->create();

        // Jenis bimbingan
        JenisBimbingan::query()->truncate();
        $prestasi = JenisBimbingan::create(['kode'=>'prestasi',   'nama_jenis'=>'Prestasi',   'poin'=>+5]);
        $pelang   = JenisBimbingan::create(['kode'=>'pelanggaran','nama_jenis'=>'Pelanggaran','poin'=>-2]);

        // Bimbingan (20 contoh acak, untuk isi grafik)
        Bimbingan::query()->truncate();
        Siswa::inRandomOrder()->take(20)->get()->each(function ($s) use ($guru,$prestasi,$pelang) {
            $isPrestasi = (bool) random_int(0,1);
            $jenis = $isPrestasi ? $prestasi : $pelang;

            Bimbingan::create([
                'tanggal'  => now()->subDays(random_int(0, 330)), // sebar setahun biar tren kelihatan
                'siswa_id' => $s->id,
                'guru_id'  => $guru->id,
                'jenis_id' => $jenis->id,
                'catatan'  => fake()->sentence(8),
                'poin'     => $jenis->poin, // cache poin
            ]);
        });
    }
}
