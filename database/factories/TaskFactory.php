<?php

namespace Database\Factories;

use App\Enums\Task\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->realText(25),
            'description' => random_int(1, 10) > 6 ? $this->faker->realText(50) : null,
            'status' => $this->faker->randomElement(TaskStatusEnum::getTypes()),
        ];
    }
}
