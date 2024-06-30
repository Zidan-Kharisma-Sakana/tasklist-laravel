<?php

namespace App\Http\Service\Impl;

use App\Http\Service\TaskService;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskServiceImpl implements TaskService{
    public function list(): Collection{
        return Task::all();
    }
    public function add(): Task{
        return Task::create();
    }
    public function update(): Task{
        return Task::findOrFail();
    }
}
