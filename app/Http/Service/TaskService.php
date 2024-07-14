<?php

namespace App\Http\Service;

use App\Http\Requests\Task\AddTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface TaskService
{
    public function list(Request $request): Collection;
    public function add(AddTaskRequest $request): Task;
    public function update(UpdateTaskRequest $request): Task;
    public function delete(Request $request);
}
