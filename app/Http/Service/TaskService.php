<?php

namespace App\Http\Service;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskService
{
    public function list(): Collection;
    public function add(): Task;
    public function update(): Task;
}
