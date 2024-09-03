<?php

namespace Tests\Feature;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Passport::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    /**
     * Test user registration.
     */
    public function testUserRegistration(): void
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/v1/register', $userData);

        // dd($response->getContent());
        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'email_verified_at', 'created_at', 'updated_at'],
                'access_token',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }

    /**
     * Test user login.
     */
    public function testUserLogin(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $loginData = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/v1/login', $loginData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'name', 'email', 'created_at', 'updated_at'],
                'token',
            ]);
    }

    /**
     * Test user logout.
     */
    public function testUserLogout(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson('/api/v1/logout');

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully logged out',
            ]);
    }

    /**
     * Test user joining a holiday.
     */
    public function testUserJoinHoliday(): void
    {
        $user = User::factory()->create();
        $holiday = Holiday::factory()->create();
        $token = $user->createToken('TestToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token",
        ])->postJson("/api/v1/holidays/{$holiday->id}/join");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Holiday joined successfully.',
            ]);

        $this->assertDatabaseHas('holiday_user', [
            'user_id' => $user->id,
            'holiday_id' => $holiday->id,
        ]);
    }
}
