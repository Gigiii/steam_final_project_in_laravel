<?php

namespace Database\Factories;

use App\Models\Franchise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $ageRatings = ['E', 'E10+', 'T', 'M', 'AO'];

        return [
            'title' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 5, 100),
            'sale_price' => $this->faker->randomFloat(2, 1, 50),
            'short_description' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'release_date' => $this->faker->date(),
            'age_rating' => $this->faker->randomElement($ageRatings),
            'franchise_id' => Franchise::factory(),
        ];
    }
}
