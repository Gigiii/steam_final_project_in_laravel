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
        $isOnSale = $this->faker->boolean(50);
    
        $price = $this->faker->randomFloat(2, 5, 100);
        $salePercentage = $isOnSale ? $this->faker->numberBetween(10, 50) : 0; 
    
        return [
            'title' => $this->faker->word,
            'price' => $price,
            'sale_price' => $isOnSale ? round($price * (1 - $salePercentage / 100), 2) : null,
            'sale_end_date' => $isOnSale ? $this->faker->dateTimeBetween('now', '+1 month') : null,
            'short_description' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'release_date' => $this->faker->date(),
            'age_rating' => $this->faker->randomElement($ageRatings),
            'franchise_id' => Franchise::factory(),
        ];
    }
    
}
