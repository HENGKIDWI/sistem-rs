<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokter>
 */
class DokterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Catatan: user_id dan nama_lengkap akan kita isi/timpa dari Seeder
            // agar datanya sinkron dengan data User.
            'spesialisasi' => $this->faker->randomElement(['Umum', 'Kardiologi', 'Bedah', 'Anak', 'Kulit']),
            'nomor_str' => 'STR-' . $this->faker->unique()->numerify('1000##########'),
        ];
    }
}