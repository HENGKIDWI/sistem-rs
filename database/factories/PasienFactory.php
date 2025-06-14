<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Catatan: user_id dan nama akan kita isi/timpa dari Seeder.
            'nomor_rekam_medis' => 'RM-' . $this->faker->unique()->numerify('2025######'),
            'tanggal_lahir' => $this->faker->date(),
            'alamat' => $this->faker->address(),
            'nomor_telepon' => $this->faker->phoneNumber(),
        ];
    }
}