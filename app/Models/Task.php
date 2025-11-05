<?php

namespace App\Models;

use App\Enums\Task\TaskStatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function PHPUnit\Framework\isNull;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => TaskStatusEnum::class,
    ];

    protected function getStatusLabelAttribute(): string
    {
        return $this->status->getLabel();
    }

    protected function getIsDeletedAttribute(): bool
    {
        return is_null($this->deleted_at);
    }
}
