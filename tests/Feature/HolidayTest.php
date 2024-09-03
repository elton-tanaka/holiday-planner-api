<?php

namespace Tests\Feature;

use App\Models\Holiday;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class HolidayTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test creating a holiday.
     */
    public function testCreateHoliday(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $holidayData = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => $this->faker->date,
            'location' => $this->faker->city,
        ];

        $response = $this->postJson('/api/v1/holidays', $holidayData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'date',
                'location',
                'created_at',
                'updated_at',
            ]);

        $this->assertDatabaseHas('holidays', [
            'title' => $holidayData['title'],
        ]);
    }

    /**
     * Test updating a holiday.
     */
    public function testUpdateHoliday(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $holiday = Holiday::factory()->create();

        $updateData = [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'date' => $this->faker->date,
            'location' => 'Updated Location',
        ];

        $response = $this->putJson("/api/v1/holidays/{$holiday->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'title' => 'Updated Title',
                'description' => 'Updated Description',
                'location' => 'Updated Location',
            ]);

        $this->assertDatabaseHas('holidays', [
            'id' => $holiday->id,
            'title' => 'Updated Title',
        ]);
    }

    /**
     * Test deleting a holiday.
     */
    public function testDeleteHoliday(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $holiday = Holiday::factory()->create();

        $response = $this->deleteJson("/api/v1/holidays/{$holiday->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('holidays', [
            'id' => $holiday->id,
        ]);
    }

    /**
     * Test joining a holiday.
     */
    public function testJoinHoliday(): void
    {
        $user = User::factory()->create();
        $holiday = Holiday::factory()->create();
        Passport::actingAs($user);

        $response = $this->postJson("/api/v1/holidays/{$holiday->id}/join");

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
