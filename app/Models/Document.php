<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'status',
        'uploaded_date',
        'verified_date',
        'notes',
        'lead_id',
        'pan_path',
        'aadhaar_path',
        'bill_path',
        'bank_path',
        'geo_path',
        'email_val',
        'mobile_val'
    ];

    protected $casts = [
        'uploaded_date' => 'date',
        'verified_date' => 'date'
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }
}