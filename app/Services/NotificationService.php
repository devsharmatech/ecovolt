<?php

namespace App\Services;

use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log; // यह add करें

class NotificationService
{
    /**
     * Send notification based on trigger
     */
    public function sendNotification($trigger, $data = [], $specificRecipient = null)
    {
        // Get notification settings for this trigger
        $settings = NotificationSetting::where('alert_trigger', 'LIKE', "%{$trigger}%")
            ->where('is_active', true)
            ->get();

        if ($settings->isEmpty()) {
            Log::warning("No notification settings found for trigger: {$trigger}");
            return false;
        }

        foreach ($settings as $setting) {
            // Check frequency (for Immediately only in this example)
            if ($setting->frequency === 'Immediately') {
                
                // Get recipients
                $recipients = $this->getRecipients($setting->recipient, $specificRecipient);
                
                if ($recipients->isEmpty()) {
                    Log::warning("No recipients found for setting ID: {$setting->id}");
                    continue;
                }

                // Send notification based on channels
                $channels = $setting->channels ? explode(',', $setting->channels) : ['database'];
                
                foreach ($channels as $channel) {
                    $this->sendViaChannel($channel, $recipients, $trigger, $data, $setting);
                }
                
                // Log notification
                $this->logNotification($setting, $recipients, $trigger);
            }
        }

        return true;
    }

    /**
     * Get recipients based on recipient type
     */
    private function getRecipients($recipientType, $specificRecipient = null)
    {
        if ($specificRecipient) {
            return $specificRecipient instanceof User 
                ? collect([$specificRecipient])
                : User::where('email', $specificRecipient)->get();
        }

        switch ($recipientType) {
            case 'Admin User':
                // Assuming you have spatie/laravel-permission package
                if (class_exists('\Spatie\Permission\Models\Role')) {
                    return User::role('admin')->get();
                }
                return User::where('role', 'admin')->get();
                
            case 'Super Admin':
                if (class_exists('\Spatie\Permission\Models\Role')) {
                    return User::role('super-admin')->get();
                }
                return User::where('role', 'super-admin')->get();
                
            case 'Document Manager':
                if (class_exists('\Spatie\Permission\Models\Role')) {
                    return User::role('document-manager')->get();
                }
                return User::where('role', 'document-manager')->get();
                
            case 'All Users':
                return User::all();
                
            default:
                // Check if it's an email address
                if (filter_var($recipientType, FILTER_VALIDATE_EMAIL)) {
                    return User::where('email', $recipientType)->get();
                }
                
                // Check if it's a user ID
                if (is_numeric($recipientType)) {
                    return User::where('id', $recipientType)->get();
                }
                
                return collect();
        }
    }

    /**
     * Send notification via specific channel
     */
    private function sendViaChannel($channel, $recipients, $trigger, $data, $setting)
    {
        try {
            switch ($channel) {
                case 'mail':
                    $notificationClass = $this->getNotificationClass($trigger);
                    if (class_exists($notificationClass)) {
                        Notification::send($recipients, new $notificationClass($data));
                        Log::info("Email notification sent via {$notificationClass}");
                    }
                    break;
                    
                case 'database':
                    foreach ($recipients as $recipient) {
                        $recipient->notifications()->create([
                            'type' => $this->getNotificationType($trigger),
                            'notifiable_type' => get_class($recipient),
                            'notifiable_id' => $recipient->id,
                            'data' => [
                                'trigger' => $trigger,
                                'message' => $this->getMessage($trigger, $data),
                                'data' => $data,
                                'setting_id' => $setting->id,
                                'timestamp' => now()->toDateTimeString()
                            ],
                            'read_at' => null,
                        ]);
                        Log::info("Database notification created for user ID: {$recipient->id}");
                    }
                    break;
                    
                default:
                    Log::warning("Unsupported channel: {$channel}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send notification via {$channel}: " . $e->getMessage());
        }
    }

    /**
     * Get notification class based on trigger
     */
    private function getNotificationClass($trigger)
    {
        $mapping = [
            'Document Overdue' => \App\Notifications\DocumentOverdueNotification::class,
            'Document Approval Required' => \App\Notifications\DocumentApprovalNotification::class,
            'System Maintenance' => \App\Notifications\SystemMaintenanceNotification::class,
        ];

        foreach ($mapping as $key => $class) {
            if (str_contains($trigger, $key)) {
                return $class;
            }
        }

        return \App\Notifications\GenericNotification::class;
    }

    /**
     * Get notification type
     */
    private function getNotificationType($trigger)
    {
        return 'App\\Notifications\\' . str_replace(' ', '', $trigger) . 'Notification';
    }

    /**
     * Get message for notification
     */
    private function getMessage($trigger, $data)
    {
        $messages = [
            'Document Overdue' => "Document '{$data['document_title']}' is overdue.",
            'Document Approval Required' => "Document '{$data['document_title']}' requires your approval.",
            'System Maintenance' => "System maintenance scheduled.",
        ];

        foreach ($messages as $key => $message) {
            if (str_contains($trigger, $key)) {
                return $message;
            }
        }

        return "New notification: {$trigger}";
    }

    /**
     * Log notification for tracking
     */
    private function logNotification($setting, $recipients, $trigger)
    {
        Log::info("Notification sent", [
            'trigger' => $trigger,
            'setting_id' => $setting->id,
            'recipient_count' => $recipients->count(),
            'channels' => $setting->channels,
            'frequency' => $setting->frequency,
            'timestamp' => now()->toDateTimeString()
        ]);
    }

    /**
     * Test notification functionality
     */
    public function testNotification($trigger = 'Document Overdue', $testEmail = null)
    {
        try {
            $testData = [
                'document_id' => 999,
                'document_title' => 'Test Document',
                'due_date' => now()->format('Y-m-d'),
                'test_mode' => true,
                'trigger' => $trigger
            ];

            Log::info("Starting test notification for trigger: {$trigger}");
            
            $result = $this->sendNotification($trigger, $testData, $testEmail);
            
            $message = $result 
                ? "Test notification sent successfully for trigger: {$trigger}" 
                : "Failed to send test notification";
            
            Log::info($message);
            
            return [
                'success' => $result,
                'message' => $message,
                'data' => $testData
            ];
            
        } catch (\Exception $e) {
            Log::error("Test notification error: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => "Error: " . $e->getMessage(),
                'data' => null
            ];
        }
    }
}