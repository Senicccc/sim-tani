<?php

namespace Database\Factories;

use App\Models\JenisPekerjaan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JenisPekerjaan>
 */
class JenisPekerjaanFactory extends Factory
{
    protected $model = JenisPekerjaan::class;

    public function definition(): array
    {
        return [
            'nama_pekerjaan' => fake()->unique()->jobTitle(),
            'deskripsi' => fake()->sentence(),
            'satuan' => fake()->randomElement(['hari', 'kg', 'orang', 'lokasi']),
            'tarif_default' => fake()->numberBetween(100000, 500000),
            'status_aktif' => true,
            'created_by' => User::query()->inRandomOrder()->value('id') ?? User::factory()->create()->id,
        ];
    }
}
