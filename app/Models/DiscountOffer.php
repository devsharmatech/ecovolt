<?php
// app/Models/DiscountOffer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountOffer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rule_name',
        'description',
        'discount_type',
        'value',
        'status',
        'applicable_to',
        'minimum_order_amount',
        'start_date',
        'end_date',
        'repeat',
        'repeat_days',
        'approved_by',
        'approved_date',
        'created_by',
        'updated_by',
        'rejection_reason'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
        'repeat_days' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_date' => 'date'
    ];

    // Relationships
    public function approvalHistory()
    {
        return $this->hasMany(DiscountApprovalHistory::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    // Accessors
    public function getFormattedValueAttribute()
    {
        return $this->discount_type === 'percentage' 
            ? $this->value . '%' 
            : '$' . number_format($this->value, 2);
    }

    public function getIsActiveAttribute()
    {
        return $this->status === 'active';
    }

    public function getIsPendingAttribute()
    {
        return $this->status === 'pending';
    }
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}