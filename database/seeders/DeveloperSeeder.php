<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Franchise;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = Genre::all();
        
        Developer::factory(5)
            ->has(
                Franchise::factory(rand(1, 2))
                    ->has(
                        Game::factory(rand(3, 5))
                            ->hasAttached($genres->random(rand(5, 8)), ['genreable_type' => Game::class]) // Attach genres to games
                            ->has(
                                Image::factory(rand(3, 4))
                                    ->state(['imageable_type' => Game::class]) // Add images to games
                            )
                    )
                    ->hasAttached($genres->random(rand(5, 8)), ['genreable_type' => Franchise::class]) // Attach genres to franchises
                    ->has(
                        Image::factory(rand(2, 3))
                            ->state(['imageable_type' => Franchise::class]) // Add images to franchises
                    )
            )
            ->create();
    }
}
