<?php

namespace App\Http\Controllers\Api\V_1\Task;

use App\Facades\Task\TaskFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Resources\Task\ShowResource;
use App\Traits\Response\ResponseTrait;

class StoreController extends Controller
{
    use ResponseTrait;
    public function __invoke(StoreRequest $request)
    {
        $data = $request->validated();

        $task = TaskFacade::store($data);
        $taskResource = ShowResource::make($task)->resolve();

        return $this->successCreateResponse('Задача', ['task' => $taskResource]);
    }
}
