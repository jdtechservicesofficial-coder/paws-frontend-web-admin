<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notification {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test push notification to a specific user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user_id');

        $data = [
            'user_id' => $userId,
            'title' => 'Test Notification! 🚀',
            'description' => 'This is a test notification to check the sound and banner. Did you hear it?',
        ];

        SendPushNotification($data);

        $this->info("Test notification sent to User ID: $userId");

        return Command::SUCCESS;
    }
}
