<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wishlist;// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            GenreSeeder::class,
            DeveloperSeeder::class,
            UserSeeder::class,
        ]);
    }
}
