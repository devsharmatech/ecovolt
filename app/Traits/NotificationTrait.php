<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\User;

trait NotificationTrait
{
    /**
     * Send notification to a specific user
     */
    public function sendNotification($userId, $title, $description, $type = 'info', $link = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'type' => $type,
            'link' => $link,
            'is_read' => false
        ]);
    }

    /**
     * Notify all admins
     */
    public function notifyAdmins($title, $description, $type = 'alert', $link = null)
    {
        $admins = User::whereHas('roles', function($q) {
            $q->where('name', 'admin');
        })->get();

        foreach ($admins as $admin) {
            $this->sendNotification($admin->id, $title, $description, $type, $link);
        }
    }

    /**
     * Notify dealer
     */
    public function notifyDealer($dealerId, $title, $description, $type = 'info', $link = null)
    {
        return $this->sendNotification($dealerId, $title, $description, $type, $link);
    }

    /**
     * Notify customer (mapped to a user account)
     */
    public function notifyCustomer($customerId, $title, $description, $type = 'info', $link = null)
    {
        return $this->sendNotification($customerId, $title, $description, $type, $link);
    }
}
