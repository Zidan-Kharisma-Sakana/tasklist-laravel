<?php

namespace App\Http\Service\Impl;

use App\Http\Requests\Task\AddTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Service\TaskService;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskServiceImpl implements TaskService
{
    public function list(Request $request): Collection
    {
        return Task::where('user_id', $request->user()->id)->get();
    }
    public function add(AddTaskRequest $request): Task
    {
        return Task::create([
            "title" => $request->input("title"),
            "description" => $request->input("description"),
            "status"=> 1,
            "deadline" =>  $request->input("deadline") ? Carbon::parse($request->input("deadline")) : null,
            "user_id" => (int) $request->user()->id
        ]);
    }
    public function update(UpdateTaskRequest $request): Task
    {
        $task = Task::findOrFail($request->route("id"));
        if ($task->user_id != $request->user()->id) {
            abort(403);
        }
        $task->title = $request->input("title");
        $task->description = $request->input("description");
        $task->status = $request->input("status");
        $task->deadline =  $request->input("deadline") ? Carbon::parse($request->input("deadline")) : null;
        $task->save();
        return $task;
    }
    public function delete(Request $request) {
        $task = Task::findOrFail($request->route("id"));
        if ($task->user_id != $request->user()->id) {
            abort(403);
        }
        Task::destroy($request->route("id"));
    }
}
