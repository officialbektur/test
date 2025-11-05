<?php

namespace App\Contracts\Task;

use App\Models\Task;

interface TaskServiceContract
{
    public function store(array $data): Task;
    public function update(array $data, Task $task): Task;
    public function delete(Task $task): array;
}
