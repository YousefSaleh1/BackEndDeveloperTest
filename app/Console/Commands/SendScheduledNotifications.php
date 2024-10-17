<?php

namespace App\Console\Commands;

use App\Jobs\SendTaskReminder;
use App\Models\ScheduledNotification;
use Illuminate\Console\Command;

class SendScheduledNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-scheduled-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $notifications = ScheduledNotification::where('scheduled_time', '<=', now())->get();

        SendTaskReminder::dispatch($notifications);

        $this->info('Scheduled notifications sent successfully!');
    }
}
