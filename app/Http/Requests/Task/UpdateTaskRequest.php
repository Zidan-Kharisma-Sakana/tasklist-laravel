<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(Request $request): bool
    {
        // dd($request);
        return true;
    }
    public function rules(): array
    {
        return [
            'title'    => ['required', 'string'],
            'status' => ['required', 'numeric']
        ];
    }
}
