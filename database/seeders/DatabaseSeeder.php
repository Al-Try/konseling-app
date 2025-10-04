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
        // 1) Kelas
        \App\Models\Kelas::query()->insert([
            ['nama_kelas' => 'X IPA 1', 'tingkat' => 'X', 'created_at'=>now(),'updated_at'=>now()],
            ['nama_kelas' => 'X IPS 1', 'tingkat' => 'X', 'created_at'=>now(),'updated_at'=>now()],
        ]);

        // 2) Users (admin & guru wali)
        $admin = \App\Models\User::create([
            'name' => 'Admin Sekolah',
            'email'=> 'admin@sekolah.com',
            'password' => bcrypt('123456'),
            'role' => 'admin',
        ]);

        $guruUser = \App\Models\User::create([
            'name' => 'Guru Wali A',
            'email'=> 'guru@sekolah.com',
            'password' => bcrypt('123456'),
            'role' => 'guru_wali',
        ]);

        $guru = \App\Models\GuruWali::create([
            'user_id'   => $guruUser->id,
            'nip'       => '19801231xxxx',
            'nama_guru' => 'Guru Wali A',
            'no_hp'     => '081234567890',
        ]);

        // 3) Siswa (random)
        \App\Models\Siswa::factory()->count(20)->create();

        // 4) Jenis bimbingan (kategori + poin)
        $prestasi = \App\Models\JenisBimbingan::create(['nama_jenis' => 'Prestasi',    'tipe'=>'positif','poin'=> 5]);
        $pelang   = \App\Models\JenisBimbingan::create(['nama_jenis' => 'Pelanggaran', 'tipe'=>'negatif','poin'=>-2]);

        // 5) Generate bimbingan contoh (acak 15–30)
        $jenis = [$prestasi->id, $pelang->id];
        $siswas = \App\Models\Siswa::inRandomOrder()->take(15)->get();
        foreach ($siswas as $s) {
            \App\Models\Bimbingan::create([
                'tanggal' => now()->subDays(rand(0,60))->format('Y-m-d'),
                'siswa_id'=> $s->id,
                'guru_id' => $guru->id,
                'jenis_id'=> $this->command->getOutput()->isVerbose() ? $jenis[array_rand($jenis)] : $jenis[array_rand($jenis)],
                'catatan' => fake()->sentence(8),
                'poin'    => rand(0,1) ? 5 : -2,
            ]);
        }
    }

}
