<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // $games = Game::all();

            // // Create Users and their Game Interactions
            // User::factory(15)
                // ->has(
                //     Library::factory(rand(5, 20))
                //         ->sequence(function ($sequence) use ($games) {
                //             // Get the game by looping through the games list
                //             $game = $games[$sequence->index % $games->count()]; // Loop back to the start using modulus
                //             return [
                //                 'game_id' => $game->id, // Assign game_id for each Library entry
                //             ];
                //         })
                //         ->has(Order::factory()
                //             ->has(PaymentDetail::factory())
                //         )
                // )
                // ->has(
                //     Wishlist::factory(rand(3, 10))
                //         ->sequence(function ($sequence) use ($games) {
                //             // Get the game by looping through the games list (similar to Library)
                //             $game = $games[$sequence->index % $games->count()]; // Loop back to the start using modulus
                //             return [
                //                 'game_id' => $game->id, // Assign game_id for each Wishlist entry
                //             ];
                //         })
                // )
                // ->has(
                //     Review::factory(rand(1, 4))
                //         ->sequence(function ($sequence) use ($games) {
                //             // Get the game by looping through the games list (similar to Library)
                //             $game = $games[$sequence->index % $games->count()]; // Loop back to the start using modulus
                //             return [
                //                 'game_id' => $game->id, // Assign game_id for each Wishlist entry
                //             ];
                //         })
                // )
            //     ->create();


            User::factory(15)
            ->has(Wishlist::factory(rand(1, 5))
                ->state(function (array $attributes, User $user) {
                    return ['user_id' => $user->id]; // Pass the user_id to the Wishlist factory
                })
            )
            ->create();

    }
}
