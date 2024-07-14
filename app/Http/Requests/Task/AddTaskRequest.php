<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class AddTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'    => ['required', 'string'],
        ];
    }
}
