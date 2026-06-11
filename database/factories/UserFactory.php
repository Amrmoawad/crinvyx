<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'full_name' => fake()->name(),
            'password' => static::$password ??= Hash::make('password'),
            'access_create_users' => false,
            'access_manage_events' => false,
            'access_record_attendees' => false,
            'remember_token' => Str::random(10),
        ];
    }
}
