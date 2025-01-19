<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Action', 'Adventure', 'Role-Playing (RPG)', 'Simulation', 'Strategy', 'Sports',
            'Puzzle', 'Casual', 'Horror', 'Racing', 'Shooter', 'Fighting',
            'Sandbox', 'Survival', 'Multiplayer', 'Singleplayer', 'MMORPG',
            'Platformer', 'Roguelike', 'Open World', 'Turn-Based', 'Card Game',
            'Tower Defense', 'Visual Novel', 'Music', 'Party Game', 'Metroidvania',
            'Battle Royale', 'Stealth', 'Rhythm', 'Comedy', 'Mystery', 'Thriller',
            'Sci-Fi', 'Fantasy', 'Historical', 'Anime', 'Narrative', 'Text-Based',
            'Board Game', 'VR', 'AR', 'Point-and-Click', 'Educational',
            'Co-op', 'Hack and Slash', 'Idle', 'MOBA', 'Tycoon', 'War',
            'Cyberpunk', 'Western', 'Dystopian', 'Post-Apocalyptic', 'Crime',
            'Exploration', 'Crafting', 'Space', 'FPS', 'Medieval'
        ];

        foreach ($genres as $genre) {
            DB::table('genres')->insert([
                'title' => $genre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
