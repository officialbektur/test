<?php

namespace App\Actions\Task;

use App\Models\Task;
use App\Enums\Task\TaskStatusEnum;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class UpdateAction
{
    public function handle(array $data, Task $task): Task
    {
        try {
            $currentStatus = $task->status;
            if ($currentStatus->isFinal()) {
                throw new HttpException(400, 'Нельзя редактировать завершённую или отменённую задачу.');
            }

            $newStatus = TaskStatusEnum::from((int)$data['status']);
            if ($currentStatus !== $newStatus && !$currentStatus->canTransitionTo($newStatus)) {
                throw new HttpException(400, 'Недопустимый переход статуса.');
            }

            $task->update([
                'title' => $data['title'],
                'description' => $data['description'],
                'status' => $data['status'],
            ]);

            return $task->refresh();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}
