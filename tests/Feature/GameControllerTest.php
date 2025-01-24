<?php

namespace Tests\Feature;

use App\Models\Developer;
use App\Models\Franchise;
use App\Models\Game;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    public function test_it_can_fetch_all_games()
    {
        Game::factory(10)->create();

        $response = $this->getJson('/api/games');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data',
            ]);
    }

    public function test_it_can_show_a_single_game_with_relationships()
    {
        $franchise = Franchise::factory()->create();
        $game = Game::factory()->create(['franchise_id' => $franchise->id]);

        $response = $this->getJson("/api/games/{$game->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'genres',
                'images',
                'reviews',
            ]);
    }

    public function test_it_allows_a_developer_to_create_a_game()
    {
        $developer = $this->createDeveloperUser();
        $franchise = Franchise::factory()->create(['developer_id' => $developer->developer->id]);

        $data = [
            'title' => 'New Game',
            'description' => 'Description of the game',
            'short_description' => 'Short description of the game',
            'price' => 59.99,
            'release_date' => now()->format('Y-m-d'),
            'age_rating' => 'T',
            'franchise_id' => $franchise->id,
        ];

        $token = JWTAuth::fromUser($developer->user);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/games', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'თამაში წარმატებით შეიქმნა.',
                'data' => [
                    'title' => 'New Game',
                    'description' => 'Description of the game',
                ],
            ]);

        $this->assertDatabaseHas('games', ['title' => 'New Game']);
    }

    public function test_it_prevents_a_non_developer_from_creating_a_game()
    {
        $franchise = Franchise::factory()->create();
        $user = User::factory()->create(['role_id' => Role::where('title', 'user')->first()->id]);
        
        $data = [
            'title' => 'New Game',
            'description' => 'Description of the game',
            'short_description' => 'Short description of the game',
            'price' => 59.99,
            'release_date' => now()->format('Y-m-d'),
            'age_rating' => 'T',
            'franchise_id' => $franchise->id,
        ];

        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->postJson('/api/games', $data);

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'მხოლოდ დეველოპერებს შეუძლიათ თამაშის დამატება.',
            ]);
    }

    public function test_it_allows_a_developer_to_update_a_game()
    {
        $developer = $this->createDeveloperUser();
        $franchise = Franchise::factory()->create(['developer_id' => $developer->developer->id]);
        $game = Game::factory()->create(['franchise_id' => $franchise->id]);

        $data = ['title' => 'Updated Game Title'];

        $token = JWTAuth::fromUser($developer->user);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->putJson("/api/games/{$game->id}", $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'თამაში წარმატებით განახლდა.',
                'data' => [
                    'title' => 'Updated Game Title',
                ],
            ]);

        $this->assertDatabaseHas('games', ['id' => $game->id, 'title' => 'Updated Game Title']);
    }

    public function test_it_prevents_a_non_developer_from_updating_a_game()
    {
        $user = User::factory()->create();
        $game = Game::factory()->create();

        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->putJson("/api/games/{$game->id}", [
                'title' => 'New Title',
            ]);

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'მხოლოდ დეველოპერებს შეუძლიათ თამაშის განახლება.',
            ]);
    }

    public function test_it_allows_a_developer_to_delete_a_game()
    {
        $developer = $this->createDeveloperUser();
        $franchise = Franchise::factory()->create(['developer_id' => $developer->developer->id]);
        $game = Game::factory()->create(['franchise_id' => $franchise->id]);

        $token = JWTAuth::fromUser($developer->user);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->deleteJson("/api/games/{$game->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'თამაში წარმატებით წაიშალა.',
            ]);

        $this->assertDatabaseMissing('games', ['id' => $game->id]);
    }

    public function test_it_prevents_a_non_developer_from_deleting_a_game()
    {
        $user = User::factory()->create();
        $game = Game::factory()->create();

        $token = JWTAuth::fromUser($user);
        $response = $this->withHeaders(['Authorization' => "Bearer $token"])
            ->deleteJson("/api/games/{$game->id}");

        $response->assertStatus(403)
            ->assertJson([
                'message' => 'მხოლოდ დეველოპერებს შეუძლიათ თამაშის წაშლა.',
            ]);
    }

    private function createDeveloperUser()
    {
        $user = User::factory()->developer()->create();
        $developer = Developer::factory()->create(['user_id' => $user->id]);

        return (object) [
            'user' => $user,
            'developer' => $developer,
        ];
    }
}
