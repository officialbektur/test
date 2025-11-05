<?php

namespace Feature\Api\V_1\Task;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use WithFaker;

    public function test_it_returns_task_data_successfully(): void
    {
        $task = Task::factory(1)->create()->first();

        $response = $this->get(route('api.v1.tasks.show', $task->id));

        $response->assertStatus(200)->assertJson([
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at,
            'status' => $task->status_label,
            'status_code' => $task->status->value,
        ]);

        $this->assertEquals(1, Task::count());
    }
    public function test_it_returns_404_when_task_not_found()
    {
        $this->assertEquals(0, Task::count());

        $response = $this->deleteJson(route('api.v1.tasks.show', 1));

        $response->assertStatus(404);
        $this->assertEquals(0, Task::count());
    }
}
