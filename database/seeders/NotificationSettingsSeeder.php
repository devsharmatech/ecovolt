<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Admin Panel Push Notifications
            [
                'notification_type' => 'admin_panel_push',
                'alert_trigger' => 'Document Overdue update',
                'recipient' => 'Admin User',
                'channels' => 'database',
                'frequency' => 'Immediately',
                'is_active' => true,
            ],
            [
                'notification_type' => 'admin_panel_push',
                'alert_trigger' => 'Document Overdue',
                'recipient' => 'Super Admin',
                'channels' => 'database',
                'frequency' => 'Daily Digest',
                'is_active' => true,
            ],
            
            // Email Alerts
            [
                'notification_type' => 'email_alerts',
                'alert_trigger' => 'Document Approval Required',
                'recipient' => 'Document Manager',
                'channels' => 'mail',
                'frequency' => 'Immediately',
                'is_active' => true,
            ],
            [
                'notification_type' => 'email_alerts',
                'alert_trigger' => 'System Maintenance',
                'recipient' => 'All Users',
                'channels' => 'mail',
                'frequency' => 'Weekly',
                'is_active' => true,
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('notification_settings')->updateOrInsert(
                [
                    'notification_type' => $setting['notification_type'],
                    'alert_trigger' => $setting['alert_trigger']
                ],
                $setting
            );
        }
    }
}