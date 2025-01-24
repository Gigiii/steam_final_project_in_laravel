<?php

namespace Tests\Feature;

use App\Models\Genre;
use Database\Seeders\GenreSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GenreControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_retrieves_all_genres_successfully()
    {

        $this->seed(GenreSeeder::class);

        $response = $this->getJson('/api/genres');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'message',
            ])
            ->assertJson([
                'message' => 'Available genres retrieved successfully.',
            ]);
    }

    public function test_it_returns_empty_list_when_no_genres_exist()
    {
        $response = $this->getJson('/api/genres');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'message' => 'Available genres retrieved successfully.',
            ]);
    }
}
