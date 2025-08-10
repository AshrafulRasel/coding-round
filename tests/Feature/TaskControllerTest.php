<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test  update*/
    public function it_can_store_a_task()
    {
        $payload = [
            'title' => 'Test task',
            'description' => 'Test description',
            'is_completed' => false,
        ];

        $response = $this->postJson('/tasks', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'Test task']);

        $this->assertDatabaseHas('tasks', ['title' => 'Test task']);
    }

    /** @test */
    public function it_returns_404_when_updating_non_existent_task()
    {
        $payload = ['is_completed' => true];

        $response = $this->patchJson('/tasks/999', $payload);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Task not found']);
    }

    /** @test */
    public function it_can_update_task()
    {
        $task = Task::factory()->create(['is_completed' => false]);

        $payload = ['is_completed' => true];

        $response = $this->patchJson("/tasks/{$task->id}", $payload);

        $response->assertStatus(200)
                 ->assertJsonFragment(['is_completed' => true]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }

    /** @test */
    public function it_returns_only_pending_tasks()
    {
        Task::factory()->create(['is_completed' => false]);
        Task::factory()->create(['is_completed' => true]);

        $response = $this->getJson('/tasks/pending');

        $response->assertStatus(200)
                 ->assertJsonCount(1)
                 ->assertJsonFragment(['is_completed' => false]);
    }
}
