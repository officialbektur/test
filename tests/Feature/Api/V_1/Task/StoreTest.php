<?php

namespace Feature\Api\V_1\Task;

use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use WithFaker;

    protected array $data;

    protected function setUp(): void
    {
        parent::setUp();

        $task = Task::factory()->make();
        $this->data = [
            'title' => $task->title,
            'description' => $task->description,
        ];
    }

    public function test_it_stores_task_successfully()
    {
         $this->assertEquals(0, Task::count());

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'task' => [
                    'title' => $this->data['title'],
                    'description' => $this->data['description'],
                    'status_code' => TaskStatusEnum::getDefault()->value,
                ],
            ]);

         $this->assertEquals(1, Task::count());
    }

    public function test_it_stores_task_when_description_is_provided()
    {
         $this->assertEquals(0, Task::count());

        $this->data['description'] = $this->faker->realText(50);

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(201)
            ->assertJson([
                'task' => [
                    'title' => $this->data['title'],
                    'description' => $this->data['description'],
                    'status_code' => TaskStatusEnum::getDefault()->value,
                ],
            ]);

         $this->assertEquals(1, Task::count());
    }

    public function test_it_stores_task_when_description_is_null()
    {
         $this->assertEquals(0, Task::count());

        $this->data['description'] = null;

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(201)
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

        $this->data['description'] = '12';

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);

         $this->assertEquals(0, Task::count());
    }

    public function test_it_returns_validation_error_when_description_exceeds_max_length()
    {
         $this->assertEquals(0, Task::count());

        $this->data['description'] = str_repeat('a', 65536);
        $this->assertEquals(65536, strlen($this->data['description']));

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);

         $this->assertEquals(0, Task::count());
    }

    public function test_it_returns_validation_error_when_description_is_not_string()
    {
         $this->assertEquals(0, Task::count());

        $this->data['description'] = 12345;

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['description']);

         $this->assertEquals(0, Task::count());
    }

    public function test_it_returns_validation_error_when_title_is_empty()
    {
         $this->assertEquals(0, Task::count());

        $this->data['title'] = '';

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

         $this->assertEquals(0, Task::count());
    }

    public function test_it_returns_validation_error_when_title_is_below_min_length()
    {
         $this->assertEquals(0, Task::count());

        $this->data['title'] = '12';

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

         $this->assertEquals(0, Task::count());
    }

    public function test_it_returns_validation_error_when_title_exceeds_max_length()
    {
         $this->assertEquals(0, Task::count());

        $this->data['title'] = str_repeat('a', 256);
        $this->assertEquals(256, strlen($this->data['title']));

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

         $this->assertEquals(0, Task::count());
    }

    public function test_it_returns_validation_error_when_title_is_not_string()
    {
         $this->assertEquals(0, Task::count());

        $this->data['title'] = 12345;

        $response = $this->postJson(route('api.v1.tasks.store'), $this->data);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);

         $this->assertEquals(0, Task::count());
    }
}
