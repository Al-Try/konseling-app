<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nis'           => $this->faker->unique()->numerify('20########'),
            'nama_siswa'    => $this->faker->name(),
            'kelas_id'      => Kelas::inRandomOrder()->value('id'),
            'jk'            => $this->faker->randomElement(['L','P']),
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-15 years'),
        ];
    }
}
