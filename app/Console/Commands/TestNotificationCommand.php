<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class TestNotificationCommand extends Command
{
    protected $signature = 'notification:test 
                            {trigger=Document Overdue : Notification trigger}
                            {--email= : Specific email to test}';
    
    protected $description = 'Test notification system';

    public function handle()
    {
        $service = app(NotificationService::class);
        
        $result = $service->testNotification(
            $this->argument('trigger'),
            $this->option('email')
        );
        
        if ($result['success']) {
            $this->info('✅ ' . $result['message']);
            $this->table(
                ['Key', 'Value'],
                array_map(fn($k, $v) => [$k, $v], 
                    array_keys($result['data']), 
                    array_values($result['data'])
                )
            );
        } else {
            $this->error('❌ ' . $result['message']);
        }
        
        return $result['success'] ? 0 : 1;
    }
}