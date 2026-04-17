<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'system_type',
        'kw_capacity',
        'full_address',
        'city',
        'state',
        'pincode',
        'geo_latitude',
        'geo_longitude',
        'assigned_employee_id',
        'dealer_id',
        'stage',
        'is_archive',
        'assigned_at',
        'sla_alert_at',
        'sla_escalate_at',
        'booking_amount',
        'survey_done_at',
        'quotation_sent_at',
        'booking_done_at'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}