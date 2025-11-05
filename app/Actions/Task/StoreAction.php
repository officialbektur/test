<?php

namespace App\Actions\Task;

use App\Models\Task;

class StoreAction
{
    public function handle(array $data): Task
    {
        try {
            return Task::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
            ]);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
