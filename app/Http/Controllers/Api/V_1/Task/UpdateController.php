<?php

namespace App\Http\Controllers\Api\V_1\Task;

use App\Enums\Task\TaskStatusEnum;
use App\Facades\Task\TaskFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\UpdateRequest;
use App\Http\Resources\Task\ShowResource;
use App\Models\Task;
use App\Traits\Response\ResponseTrait;

class UpdateController extends Controller
{
    use ResponseTrait;
    public function __invoke(UpdateRequest $request, $id)
    {
        $data = $request->validated();

        $task = Task::find($id);
        if (!$task) {
            return $this->notFoundResponse('Задача');
        }

        $task = TaskFacade::update($data, $task);
        $taskResource = ShowResource::make($task)->resolve();

        return $this->successUpdateResponse('Задача', ['task' => $taskResource]);
    }
}
