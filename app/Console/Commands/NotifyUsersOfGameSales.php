<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\User;
use App\Notifications\GameOnSaleNotification;
use Illuminate\Console\Command;

class NotifyUsersOfGameSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:game-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users if games from their wishlist are on sale.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $users = User::with('wishlist.game')
            ->get();

        $gamesOnSale = Game::whereNotNull('sale_price')
            ->where('sale_end_date', '>', now())
            ->get()
            ->keyBy('id');

        foreach ($users as $user) {
            $gamesOnSaleForUser = [];

            foreach ($user->wishlist as $wishlist) {
                $game = $wishlist->game;
                if ($game && isset($gamesOnSale[$game->id])) {
                    $gamesOnSaleForUser[] = $game;
                }
            }

            if (!empty($gamesOnSaleForUser)) {
                $user->notify(new GameOnSaleNotification($gamesOnSaleForUser));
                $this->info("Notification sent to user {$user->username} with " . count($gamesOnSaleForUser) . " games on sale.");
            }
        }

        $this->info('Notifications sent successfully.');
    }
}
