<?php

namespace App\Providers;

use App\Contracts\Task\TaskServiceContract;
use App\Services\Task\TaskService;
use Illuminate\Support\ServiceProvider;

class ServiceBindingProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskServiceContract::class, TaskService::class);
    }
}
