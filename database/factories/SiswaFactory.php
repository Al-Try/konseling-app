<?php

namespace Database\Factories;

use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    public function definition(): array
    {
        $kelasId = Kelas::inRandomOrder()->value('id') ?? Kelas::factory()->create()->id;

        return [
            'nis'           => $this->faker->unique()->numerify('20########'),
            'nama_siswa'    => $this->faker->name(),
            'kelas_id'      => $kelasId,
            'jk'            => $this->faker->randomElement(['L','P']),
            'tanggal_lahir' => $this->faker->date(),
        ];
    }
}
