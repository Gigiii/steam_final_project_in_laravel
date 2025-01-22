<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wishlist>
 */
class WishlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = $this->state['user_id'];

        // Get the list of games that are already in the user's Library
        $userLibraryGames = Game::whereHas('libraries', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->pluck('id')->toArray();

        // Get a game that is NOT in the user's library
        $game = Game::whereNotIn('id', $userLibraryGames)->inRandomOrder()->first();

        // If no games available that are not in the user's library, fallback to any random game
        if (!$game) {
            $game = Game::inRandomOrder()->first();
        }

        return [
            'user_id' => $userId, // Assign the specific user_id passed to the factory
            'game_id' => $game->id, // Assign the game that is not in the user's library
        ];
    }
}
