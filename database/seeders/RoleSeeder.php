<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['title' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'developer', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
