<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        // pilih kelas yang sudah ada
        $kelasId = Kelas::inRandomOrder()->value('id');

        return [
            'nis'           => $this->faker->unique()->numerify('20########'),
            'nama_siswa'    => $this->faker->name(),
            'kelas_id'      => $kelasId,
            'jk'            => $this->faker->randomElement(['L','P']),
            'tanggal_lahir' => $this->faker->date('Y-m-d','2010-12-31'),
            // tambahkan kolom lain kalau ada (alamat, no_hp, orang_tua, dsb)
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
