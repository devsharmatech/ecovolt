<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class DocumentOverdueNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $document;

    public function __construct($document)
    {
        $this->document = $document;
    }

    public function via($notifiable)
    {
        // यहाँ Determine करें कि किस Channel से भेजना है
        // आप Database में Setting से Check कर सकते हैं
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Document Overdue Alert: ' . $this->document->title)
            ->line('A document is overdue.')
            ->line('Document: ' . $this->document->title)
            ->action('View Document', url('/documents/' . $this->document->id))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'document_id' => $this->document->id,
            'document_title' => $this->document->title,
            'message' => 'Document "' . $this->document->title . '" is overdue.',
            'url' => '/documents/' . $this->document->id,
            'type' => 'document_overdue'
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'document_id' => $this->document->id,
            'message' => 'Document is overdue.'
        ];
    }
}