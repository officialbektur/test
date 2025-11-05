<?php

namespace Feature\Api\V_1\Task;

use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use WithFaker;

    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $this->data = [
            'title' => 'new title',
            'description' => 'new description',
            'status' => TaskStatusEnum::getDefault()->value,
        ];
    }

    public function test_it_updates_task_successfully()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'task' => [
                    'title' => $this->data['title'],
                    'description' => $this->data['description'],
                    'status_code' => TaskStatusEnum::getDefault()->value,
                ],
            ]);

         $this->assertEquals(1, Task::count());
    }

    public function test_it_updates_task_when_description_is_provided()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['description'] = $this->faker->realText(50);

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'task' => [
                    'title' => $this->data['title'],
                    'description' => $this->data['description'],
                    'status_code' => TaskStatusEnum::getDefault()->value,
                ],
            ]);

         $this->assertEquals(1, Task::count());
    }

    public function test_it_updates_task_when_description_is_null()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['description'] = null;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'task' => [
                    'title' => $this->data['title'],
                    'description' => $this->data['description'],
                    'status_code' => TaskStatusEnum::getDefault()->value,
                ],
            ]);

         $this->assertEquals(1, Task::count());
    }

    public function test_it_returns_validation_error_when_description_is_below_min_length()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['description'] = '12';

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
    }

    public function test_it_returns_validation_error_when_description_exceeds_max_length()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['description'] = str_repeat('a', 65536);
        $this->assertEquals(65536, strlen($this->data['description']));

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
    }

    public function test_it_returns_validation_error_when_description_is_not_string()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['description'] = 12345;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);
    }

    public function test_it_returns_validation_error_when_title_is_empty()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['title'] = '';

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_it_returns_validation_error_when_title_is_below_min_length()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['title'] = '12';

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_it_returns_validation_error_when_title_exceeds_max_length()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['title'] = str_repeat('a', 256);
        $this->assertEquals(256, strlen($this->data['title']));

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_it_returns_validation_error_when_title_is_not_string()
    {
        $this->assertEquals(0, Task::count());
        $task = Task::factory(1)->create([
            'status' => TaskStatusEnum::getDefault()->value,
        ])->first();

        $this->data['title'] = 12345;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    // -------------------start
    public function test_can_transition_from_start_to_progress(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::START->value])->first();
        $task->status = TaskStatusEnum::PROGRESS->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(200)
            ->assertJson(['task' => ['status_code' => TaskStatusEnum::PROGRESS->value]]);

        $task->refresh();
        $this->assertEquals(TaskStatusEnum::PROGRESS->value, $task->status->value);
    }

    public function test_can_transition_from_start_to_cancelled(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::START->value])->first();
        $task->status = TaskStatusEnum::CANCELLED->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(200)
            ->assertJson(['task' => ['status_code' => TaskStatusEnum::CANCELLED->value]]);

        $task->refresh();
        $this->assertEquals(TaskStatusEnum::CANCELLED->value, $task->status->value);
    }

    public function test_cannot_transition_from_start_to_final(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::START->value])->first();
        $task->status = TaskStatusEnum::FINAL->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(400);
    }

    public function test_cannot_transition_from_start_to_pause(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::START->value])->first();
        $task->status = TaskStatusEnum::PAUSE->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(400);
    }
    // -------------------start


    // -------------------progress
    public function test_can_transition_from_progress_to_final(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::PROGRESS->value])->first();
        $task->status = TaskStatusEnum::FINAL->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(200)
            ->assertJson(['task' => ['status_code' => TaskStatusEnum::FINAL->value]]);

        $task->refresh();
        $this->assertEquals(TaskStatusEnum::FINAL->value, $task->status->value);
    }
    public function test_can_transition_from_progress_to_pause(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::PROGRESS->value])->first();
        $task->status = TaskStatusEnum::PAUSE->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(200)
            ->assertJson(['task' => ['status_code' => TaskStatusEnum::PAUSE->value]]);

        $task->refresh();
        $this->assertEquals(TaskStatusEnum::PAUSE->value, $task->status->value);
    }
    public function test_can_transition_from_progress_to_cancelled(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::PROGRESS->value])->first();
        $task->status = TaskStatusEnum::CANCELLED->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(200)
            ->assertJson(['task' => ['status_code' => TaskStatusEnum::CANCELLED->value]]);

        $task->refresh();
        $this->assertEquals(TaskStatusEnum::CANCELLED->value, $task->status->value);
    }

    public function test_cannot_transition_from_progress_to_start(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::PROGRESS->value])->first();
        $task->status = TaskStatusEnum::START->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(400);
    }
    // -------------------progress



    // -------------------final
    public function test_cannot_transition_from_final_to_any(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::FINAL->value])->first();
        $task->status = TaskStatusEnum::CANCELLED->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(400);
    }
    // -------------------final



    // -------------------cancelled
    public function test_cannot_transition_from_cancelled_to_any(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::CANCELLED->value])->first();
        $task->status = TaskStatusEnum::START->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(400);
    }
    // -------------------cancelled






    // -------------------pause
    public function test_can_transition_from_pause_to_progress(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::PAUSE->value])->first();
        $task->status = TaskStatusEnum::PROGRESS->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(200)
            ->assertJson(['task' => ['status_code' => TaskStatusEnum::PROGRESS->value]]);

        $task->refresh();
        $this->assertEquals(TaskStatusEnum::PROGRESS->value, $task->status->value);
    }
    public function test_can_transition_from_pause_to_cancelled(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::PAUSE->value])->first();
        $task->status = TaskStatusEnum::CANCELLED->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(200)
            ->assertJson(['task' => ['status_code' => TaskStatusEnum::CANCELLED->value]]);

        $task->refresh();
        $this->assertEquals(TaskStatusEnum::CANCELLED->value, $task->status->value);
    }
    public function test_cannot_transition_from_pause_to_start(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::PAUSE->value])->first();
        $task->status = TaskStatusEnum::START->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());

        $response->assertStatus(400);
    }
    public function test_cannot_transition_from_pause_to_final(): void
    {
        $task = Task::factory()->create(['status' => TaskStatusEnum::PAUSE->value])->first();
        $task->status = TaskStatusEnum::FINAL->value;

        $response = $this->putJson(route('api.v1.tasks.update', $task->id), $task->toArray());
        $response->assertStatus(400);
    }
    // -------------------pause




    public function test_it_returns_404_when_updates_non_existing_task()
    {
        $this->assertEquals(0, Task::count());

        $response = $this->putJson(route('api.v1.tasks.update', 1), $this->data);

        $this->assertEquals(0, Task::count());
        $response->assertStatus(404);
    }
}
