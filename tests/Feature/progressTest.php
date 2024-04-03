<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Progression;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class progressTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testProgressCanBeCreated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/api/progression/add', [
            'user_id' => $user->id,
            'poids' => 59.7,
            'taille' => 180,
            'performances' => 'good',
            'status' => 'Non terminé',
        ]);

        $response->assertStatus(200);
    }
    public function testProgressCanBeUpdated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $progression = Progression::create([
            'user_id' => $user->id,
            'poids' => 59.7,
            'taille' => 180,
            'performances' => 'good',
        ]);

        $response = $this->put('/api/progression/update/'.$progression->id, [
            'poids' => 60.0,
            'taille' => 182,
            'performances' => 'excellent',
        ]);

        $response->assertStatus(200);
    }

    public function testProgressCanBeDeleted()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $progression = Progression::create([
            'user_id' => $user->id,
            'poids' => 59.7,
            'taille' => 180,
            'performances' => 'good',
        ]);

        $response = $this->delete('/api/progression/delete/' . $progression->id);
        $response->assertStatus(200);
    }
}