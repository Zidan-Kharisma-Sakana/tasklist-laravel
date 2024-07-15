<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// TODO: Implement sub tasks
class SubTask extends Model
{
    use HasFactory;

    protected $table = 'subtasks';
    public $timestamps = true;
    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
        'task_id'
    ];

    // a subtask belongs to a task
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
