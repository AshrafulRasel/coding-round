<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_a_task()
    {
        $payload = [
            'title' => 'New Task',
            'is_completed' => false,
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'title' => 'New Task',
                     'is_completed' => false,
                 ]);

        $this->assertDatabaseHas('tasks', ['title' => 'New Task']);
    }

    /** @test */
    public function it_returns_404_when_updating_nonexistent_task()
    {
        $response = $this->patchJson('/api/tasks/999', [
            'is_completed' => true,
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'Task not found']);
    }

    /** @test */
    public function it_can_update_a_task()
    {
        $task = Task::factory()->create(['is_completed' => false]);

        $response = $this->patchJson("/api/tasks/{$task->id}", [
            'is_completed' => true,
        ]);

        $response->assertStatus(200)
                 ->assertJsonFragment(['is_completed' => true]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'is_completed' => true,
        ]);
    }

    /** @test */
    public function test_it_can_fetch_pending_tasks()
    {
        // Make sure DB is clean
        $this->refreshDatabase();

        // Create one pending task
        Task::factory()->create(['is_completed' => false]);

        // Create another completed task
        Task::factory()->create(['is_completed' => true]);

        $response = $this->getJson('/api/tasks/pending');

        $response->assertStatus(200);

        $tasks = $response->json();

    }
}
