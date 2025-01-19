<?php

namespace Database\Seeders;

use App\Models\Developer;
use App\Models\Franchise;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Image;
use App\Models\Library;
use App\Models\Order;
use App\Models\PaymentDetail;
use App\Models\Review;
use App\Models\User;
use App\Models\Wishlist;// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test Developer',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            GenreSeeder::class,
        ]);

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

            $games = Game::all();
            
            // Create Users and their Game Interactions
            User::factory(15)
                ->has(
                    Library::factory(rand(5, 20))
                        ->sequence(fn($sequence) => [
                            'game_id' => Game::inRandomOrder()->skip($sequence->index)->first()->id, // Assign unique game_id for each Library entry
                        ])
                        ->has(Order::factory()
                            ->has(PaymentDetail::factory())
                        )
                )
                ->has(
                    Wishlist::factory(rand(3, 10))
                        ->sequence(fn($sequence) => [
                            'game_id' => Game::inRandomOrder()->skip($sequence->index)->first()->id, // Assign unique game_id for each Wishlist entry
                        ])
                )
                ->has(
                    Review::factory(rand(1, 4))
                        ->sequence(fn($sequence) => [
                            'game_id' => Game::inRandomOrder()->skip($sequence->index)->first()->id, // Assign unique game_id for each Review
                        ])
                )
                ->create();

    }
}
