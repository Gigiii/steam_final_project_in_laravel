<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Image;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_it_stores_images_successfully()
    {
        $game = Game::factory()->create();

        $data = [
            'images' => [
                [
                    'url' => 'https://example.com/image1.jpg',
                    'imageable_type' => Game::class,
                    'imageable_id' => $game->id,
                ],
                [
                    'url' => 'https://example.com/image2.jpg',
                    'imageable_type' => Game::class,
                    'imageable_id' => $game->id,
                ],
            ],
        ];

        $response = $this->postJson('/api/images', $data);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'url',
                        'imageable_type',
                        'imageable_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);

        // Check that the images were saved to the database
        foreach ($data['images'] as $image) {
            $this->assertDatabaseHas('images', [
                'url' => $image['url'],
                'imageable_type' => $image['imageable_type'],
                'imageable_id' => $image['imageable_id'],
            ]);
        }
    }

    public function test_it_returns_error_when_imageable_id_does_not_exist()
    {
        $data = [
            'images' => [
                [
                    'url' => 'https://example.com/image.jpg',
                    'imageable_type' => Game::class,
                    'imageable_id' => 99999, // Non-existent ID
                ],
            ],
        ];

        $response = $this->postJson('/api/images', $data);

        $response->assertStatus(400)
            ->assertJson([
                'message' => 'ზოგი ფოტო ვერ აიტვირთა.',
                'errors' => [
                    "Imageable ID 99999 არ არსებობს App\Models\Game-ში.",
                ],
            ]);
    }

    public function test_it_retrieves_images_by_type_successfully()
    {
        $game = Game::factory()->create();

        $images = Image::factory(3)->create([
            'imageable_type' => Game::class,
            'imageable_id' => $game->id,
        ]);

        $data = [
            'imageable_type' => Game::class,
            'imageable_id' => $game->id,
        ];

        $response = $this->getJson('/api/images/by-type?' . http_build_query($data));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'url',
                        'imageable_type',
                        'imageable_id',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ]);

        foreach ($images as $image) {
            $response->assertJsonFragment([
                'id' => $image->id,
                'url' => $image->url,
            ]);
        }
    }

    public function test_it_returns_error_when_no_images_exist_for_given_type_and_id()
    {
        $data = [
            'imageable_type' => Game::class,
            'imageable_id' => 99999,
        ];
    
        $response = $this->getJson('/api/images/by-type?' . http_build_query($data));
    
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'ვერ მოიძებნა ფოტო',
            ]);
    }
}
