<?php

namespace App\Facades\Task;

use App\Models\Task;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Task store(array $data)
 * @method static Task update(array $data, Task $task)
 * @method static array delete(Task $task)
 */
class TaskFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'TaskFacade';
    }
}
