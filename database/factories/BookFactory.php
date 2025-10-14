<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['available', 'unavailable'];
        $coverFiles = collect(glob(storage_path('app/public/covers/*')))->map(function ($path) {
            return 'covers/' . basename($path);
        });

        return [
            'name' => $this->faker->sentence(3),
            'synopsis' => $this->faker->paragraph(2),
            'stock' => $this->faker->numberBetween(1, 20),
            'status_book' => $this->faker->randomElement($statuses),
            'cover' => $coverFiles->isNotEmpty() ? $coverFiles->random() : null,
        ];
    }
}
