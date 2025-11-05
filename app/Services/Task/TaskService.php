<?php

namespace App\Services\Task;


use App\Actions\Task\DeleteAction;
use App\Actions\Task\StoreAction;
use App\Actions\Task\UpdateAction;
use App\Contracts\Task\TaskServiceContract;
use App\Models\Task;

class TaskService implements TaskServiceContract
{
    public function store(array $data): Task
    {
        return (new StoreAction)->handle($data);
    }

    public function update(array $data, Task $task): Task
    {
        return (new UpdateAction)->handle($data, $task);
    }

    public function delete(Task $task): array
    {
        return (new DeleteAction)->handle($task);
    }
}
