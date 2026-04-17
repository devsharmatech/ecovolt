<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class SystemMaintenanceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        if (isset($this->data['test_mode']) && $this->data['test_mode']) {
            return ['database'];
        }
        
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject('System Maintenance Notification')
            ->line('System maintenance has been scheduled.');
        
        if (isset($this->data['schedule_time'])) {
            $message->line('Scheduled Time: ' . $this->data['schedule_time']);
        }
        
        if (isset($this->data['duration'])) {
            $message->line('Expected Duration: ' . $this->data['duration']);
        }
        
        if (isset($this->data['impact'])) {
            $message->line('Impact: ' . $this->data['impact']);
        }
        
        $message->line('Thank you for your understanding.');
        
        return $message;
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'system_maintenance',
            'title' => 'System Maintenance Scheduled',
            'message' => $this->data['message'] ?? 'System maintenance has been scheduled.',
            'schedule_time' => $this->data['schedule_time'] ?? null,
            'duration' => $this->data['duration'] ?? null,
            'impact' => $this->data['impact'] ?? 'Minimal impact expected',
            'url' => $this->data['url'] ?? '/announcements',
            'icon' => 'tools',
            'color' => 'info',
            'test_mode' => $this->data['test_mode'] ?? false
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'system_maintenance',
            'message' => 'System maintenance notification.'
        ];
    }
}