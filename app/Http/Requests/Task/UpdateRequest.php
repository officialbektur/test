<?php

namespace App\Http\Requests\Task;

use App\Enums\Task\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if (!isset($this->status) || is_null($this->status))
        {
            $this->merge([
                'status' => TaskStatusEnum::START->value
            ]);
        }
    }
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'min:3', 'max:65535'],
            'status' => ['required', 'integer', Rule::in(TaskStatusEnum::getTypes())],
        ];
    }
}
