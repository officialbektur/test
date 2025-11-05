<?php

namespace Tests\Feature\Api\V_1\Task;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use WithFaker;

    public function test_returns_empty_task_lists(): void
    {
        $this->assertEquals(0, Task::count());

        $response = $this->get(route('api.v1.tasks.index'));

        $response->assertStatus(200)->assertJson([])->assertJsonStructure([]);
    }
    public function test_returns_task_lists_with_data(): void
    {
        $this->assertEquals(0, Task::count());

        $taskCount = 10;
        Task::factory($taskCount)->create();
        $this->assertEquals($taskCount, Task::count());

        $response = $this->get(route('api.v1.tasks.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'title',
                    'created_at',
                    'updated_at',
                    'status',
                    'status_code',
                ],
            ])
            ->assertJsonCount($taskCount);
    }
}
