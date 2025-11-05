<?php

namespace App\Http\Controllers\Api\V_1\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\Task\ShowResource;
use App\Models\Task;
use App\Traits\Response\ResponseTrait;

class ShowController extends Controller
{
    use ResponseTrait;
    public function __invoke($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->notFoundResponse('Задача');
        }

        $taskResource = ShowResource::make($task)->resolve();
        return response()->json($taskResource);
    }
}
