<?php

namespace App\Http\Controllers\Api\V_1\Task;

use App\Facades\Task\TaskFacade;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Traits\Response\ResponseTrait;

class DestroyController extends Controller
{
    use ResponseTrait;
    public function __invoke($id)
    {
        $task = Task::withTrashed()->find($id);
        if (!$task) {
            return $this->notFoundResponse('Задача');
        }

        $result = TaskFacade::delete($task);

        return $result['restore'] ? $this->successRestoreResponse('Задача', $result) : $this->successDeleteResponse('Задача', $result);
    }
}
