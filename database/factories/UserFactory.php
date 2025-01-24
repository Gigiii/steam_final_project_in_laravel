<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'balance' => $this->faker->randomFloat(2,0, 999),
            'password' => static::$password ??= Hash::make('Test123!'),
            'role_id' => Role::inRandomOrder()->first()->id,
        ];
    }

    public function developer(): static
    {
        return $this->state(function () {
            return [
                'role_id' => Role::where('title', 'developer')->first()->id,
            ];
        });
    }


    public function user(): static
    {
        return $this->state(function () {
            return [
                'role_id' => Role::where('title', 'user')->first()->id,
            ];
        });
    }

}
