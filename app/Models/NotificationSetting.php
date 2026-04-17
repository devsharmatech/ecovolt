<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'notification_type',
        'alert_trigger',
        'recipient',
        'frequency',
        'is_active',
        'channels'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}