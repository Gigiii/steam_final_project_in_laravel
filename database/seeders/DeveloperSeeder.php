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
        
        Developer::factory(15)
            ->has(
                Franchise::factory(rand(1, 2))
                    ->has(
                        Game::factory(rand(3, 5))
                            ->hasAttached($genres->random(rand(5, 8)), ['genreable_type' => Game::class])
                            ->has(
                                Image::factory(rand(3, 4))
                                    ->state(['imageable_type' => Game::class])
                            )
                    )
                    ->hasAttached($genres->random(rand(5, 8)), ['genreable_type' => Franchise::class])
                    ->has(
                        Image::factory(rand(2, 3))
                            ->state(['imageable_type' => Franchise::class]) 
                    )
            )
            ->create();
    }
}
