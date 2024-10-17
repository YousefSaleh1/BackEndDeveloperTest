<?php

namespace App\Observers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskObserver
{
    /**
     * Handle the Task "creating" event.
     */
    public function creating(Task $task): void
    {
        if (Auth::check()) {
            $task->user_id = Auth::id();
        }
    }

    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $task->notification()->create([
            'scheduled_time' => Carbon::parse($task->due_date)->subHour(),
        ]);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        if ($task->isDirty('due_date')) {
            optional($task->notification)->update([
                'scheduled_time' => Carbon::parse($task->due_date)->subHour(),
            ]);
        }
    }
}
