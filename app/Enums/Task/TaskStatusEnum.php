<?php

namespace App\Enums\Task;

use Symfony\Component\HttpKernel\Exception\HttpException;

enum TaskStatusEnum: int
{
    case START = 1;      // Ожидает выполнения
    case PROGRESS = 2;  // В процессе выполнения
    case FINAL = 3;    // Завершена
    case CANCELLED = 4;    // Отменена
    case PAUSE = 5;      // Приостановлена

    public static function getDefault(): self
    {
        return self::START;
    }

    public static function getTypes(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function getTypesWithLabels(): array
    {
        return [
            self::START->value => 'Ожидает',
            self::PROGRESS->value => 'В процессе',
            self::FINAL->value => 'Завершена',
            self::CANCELLED->value => 'Отменена',
            self::PAUSE->value => 'На паузе',
        ];
    }

    public static function getStatus(int $key): string
    {
        return self::getTypesWithLabels()[$key]
            ?? throw new HttpException(404, 'Нету такого статуса в задаче!');
    }

    public function getLabel(): string
    {
        return self::getTypesWithLabels()[$this->value];
    }

    public function isFinal(): bool
    {
        return in_array($this, [self::FINAL, self::CANCELLED], true);
    }

    public static function finalStatuses(): array
    {
        return [self::FINAL, self::CANCELLED];
    }

    public function canTransitionTo(self $newStatus): bool
    {
        return match($this) {
            // Из "Ожидает" можно только начать работу или отменить
            self::START => in_array($newStatus, [self::PROGRESS, self::CANCELLED]),

            // Из "В процессе" можно завершить, приостановить или отменить
            self::PROGRESS => in_array($newStatus, [self::FINAL, self::PAUSE, self::CANCELLED]),

            // Из "На паузе" можно только возобновить или отменить
            self::PAUSE => in_array($newStatus, [self::PROGRESS, self::CANCELLED]),

            // Из финальных статусов никуда перейти нельзя
            self::FINAL, self::CANCELLED => false,
        };
    }
}
