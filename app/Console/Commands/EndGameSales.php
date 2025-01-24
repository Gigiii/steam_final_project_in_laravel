<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

class EndGameSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:end';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired game sales from all games.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gamesOnSale = Game::whereNotNull('sale_price')
            ->where('sale_end_date', '<', now())
            ->get();

        foreach($gamesOnSale as $gameOnSale){
            $gameOnSale->sale_end_date = null;
            $gameOnSale->sale_price = null;
            $gameOnSale->save();
        }

        $this->info(count($gamesOnSale) . ' games have had their sales ended.');
    }
}
