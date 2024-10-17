<?php

namespace App\Jobs;

use App\Mail\TaskReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTaskReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $notification_tasks;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notification_tasks)
    {
        $this->notification_tasks = $notification_tasks;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            foreach ($this->notification_tasks as $notification_task) {
                $task  = $notification_task->task;
                $email = $task->user->email;

                Mail::to($email)->send(new TaskReminder($task));

                $notification_task->delete();
            }
        } catch (\Exception $e) {
            Log::error('Error sending task reminders: ' . $e->getMessage());
        }
    }
}
