<?php

namespace App\Console\Commands;

use App\Models\Franchise;
use App\Models\User;
use App\Notifications\WeeklyFranchiseNotification;
use Illuminate\Console\Command;

class NotifyUsersOfWeeklyFranchise extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:weekly-franchise';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users of the weekly franchise.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $franchise = Franchise::inRandomOrder()->with(['developer', 'games'])->first();
        $users = User::all();

        foreach ($users as $user) {

            $user->notify(new WeeklyFranchiseNotification($franchise));
            $this->info("Weekly Franchise notification sent to user {$user->username}");

        }

        $this->info('Notifications sent successfully.');
    }
}
