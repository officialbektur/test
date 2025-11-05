<?php

namespace App\Http\Controllers\Api\V_1\Task;

use App\Http\Controllers\Controller;
use App\Http\Resources\Task\IndexResource;
use App\Models\Task;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tasks = Task::all();
        $tasksResource = IndexResource::collection($tasks)->resolve();

        return response()->json($tasksResource);
    }
}
