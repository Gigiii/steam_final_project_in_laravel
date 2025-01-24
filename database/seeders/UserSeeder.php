<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Image;
use App\Models\Library;
use App\Models\Order;
use App\Models\PaymentDetail;
use App\Models\Review;
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
        $games = Game::all();

        $users = User::factory(50)->user()->create();

        foreach ($users as $user) {

            $user->image()->create([
                'url' => fake()->imageUrl(),
            ]);

            $libraryGames = $games->random(rand(5, 20));
            foreach ($libraryGames as $game) {


                $order = Order::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'first_name' => fake()->firstName,
                    'last_name' => fake()->lastName,
                    'address' => fake()->address,
                ]);


                PaymentDetail::create([
                    'order_id' => $order->id,
                    'payment_method' => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer']),
                    'price' => fake()->randomFloat(2, 5, 100),
                ]);


                Library::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'order_id' => $order->id,
                ]);
            }


            $wishlistGames = $games->whereNotIn('id', $libraryGames->pluck('id'))->random(rand(3, 10));
            foreach ($wishlistGames as $game) {
                Wishlist::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                ]);
            }


            $reviewGames = $libraryGames->random(rand(1, 4)); 
            foreach ($reviewGames as $game) {
                Review::create([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                    'title' => fake()->sentence,
                    'description' => fake()->paragraph,
                    'rating' => fake()->numberBetween(1, 5),
                ]);
            }
        }
    }
}