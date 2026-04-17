<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class DocumentApprovalNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        // If test mode, only send to database
        if (isset($this->data['test_mode']) && $this->data['test_mode']) {
            return ['database'];
        }
        
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Document Approval Required: ' . ($this->data['document_title'] ?? 'Untitled Document'))
            ->line('A document requires your approval.')
            ->line('Document: ' . ($this->data['document_title'] ?? 'N/A'))
            ->line('Submitted by: ' . ($this->data['submitted_by'] ?? 'Unknown'))
            ->action('Review Document', $this->data['url'] ?? url('/documents'))
            ->line('Please review and approve at your earliest convenience.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'document_approval',
            'title' => 'Document Approval Required',
            'message' => 'Document "' . ($this->data['document_title'] ?? 'Untitled') . '" requires your approval.',
            'document_id' => $this->data['document_id'] ?? null,
            'document_title' => $this->data['document_title'] ?? 'Untitled Document',
            'submitted_by' => $this->data['submitted_by'] ?? 'Unknown',
            'url' => $this->data['url'] ?? '/documents',
            'icon' => 'file-check',
            'color' => 'warning',
            'test_mode' => $this->data['test_mode'] ?? false
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'document_approval',
            'document_id' => $this->data['document_id'] ?? null,
            'message' => 'Document approval required.'
        ];
    }
}