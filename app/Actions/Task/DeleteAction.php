<?php

namespace App\Actions\Task;

use App\Models\Task;

class DeleteAction
{
    public function handle(Task $task): array
    {
        try {
            if (!$task->isDeleted) {
                $task->restore();

                return [
                    'status' => true,
                    'restore' => true,
                ];
            }

            $task->delete();

            return [
                'status' => true,
                'restore' => false,
            ];
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
