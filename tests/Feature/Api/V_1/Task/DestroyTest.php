<?php

namespace Feature\Api\V_1\Task;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use WithFaker;

    public function test_it_deletes_a_category_successfully(): void
    {
        $task = Task::factory()->create()->first();

        $response = $this->deleteJson(route('api.v1.tasks.destroy', $task->id));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'status',
                'restore',
            ])
            ->assertJson([
                'status' => true,
                'restore' => false,
            ]);

        $this->assertTrue($task->fresh()->trashed());
    }
    public function test_it_restores_a_deleted_task_successfully()
    {
        $task = Task::factory()->create()->first();
        $task->delete();

        $response = $this->deleteJson(route('api.v1.tasks.destroy', $task->id));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'status',
                'restore',
            ])
            ->assertJson([
                'status' => true,
                'restore' => true,
            ]);

        $this->assertFalse($task->fresh()->trashed());
    }
    public function test_it_returns_404_when_deleting_non_existing_task()
    {
        $this->assertEquals(0, Task::count());

        $response = $this->deleteJson(route('api.v1.tasks.destroy', 1));

        $this->assertEquals(0, Task::count());
        $response->assertStatus(404);
    }
}
