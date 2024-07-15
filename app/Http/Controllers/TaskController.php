<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\AddTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Service\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService){
        $this->taskService = $taskService;
    }

    public function addTask(AddTaskRequest $request){
        return $this->taskService->add($request);
    }

    public function list(Request $request){
        return $this->taskService->list($request);
    }

    public function update(UpdateTaskRequest $request){
        return $this->taskService->update($request);;
    }
    public function destroy(Request $request){
        $this->taskService->delete($request);
        return "success";
    }
}
