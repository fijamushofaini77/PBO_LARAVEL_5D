<?php

namespace Database\Factories;

use App\Models\Periode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Periode>
 */
class PeriodeFactory extends Factory
{
    protected $model = Periode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $year = fake()->numberBetween(2024, 2030);
        $nextYear = $year + 1;
        $term = fake()->randomElement(['GANJIL', 'GENAP']);

        return [
            'periode' => "{$term} {$year}/{$nextYear}",
            'singkatan' => (string) fake()->unique()->numerify('###'),
            'status' => fake()->boolean(80),
        ];
    }
}
