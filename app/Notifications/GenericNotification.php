<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        // Check if test mode
        if (isset($this->data['test_mode']) && $this->data['test_mode']) {
            return ['database'];
        }
        
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->data['subject'] ?? 'Notification')
            ->line($this->data['message'] ?? 'You have a new notification.')
            ->action('View', $this->data['url'] ?? url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->data['type'] ?? 'generic',
            'message' => $this->data['message'] ?? 'New notification',
            'data' => $this->data,
            'icon' => $this->data['icon'] ?? 'bell',
            'url' => $this->data['url'] ?? '/',
            'test_mode' => $this->data['test_mode'] ?? false
        ];
    }
}