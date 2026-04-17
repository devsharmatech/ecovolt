<?php
// app/Models/DiscountApprovalHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountApprovalHistory extends Model
{
    use HasFactory;
    protected $table = 'discount_approval_histories';

    protected $fillable = [
        'discount_offer_id',
        'action',
        'acted_by',
        'comments'
    ];

    protected $casts = [
        'acted_at' => 'datetime'
    ];

    // Relationships
    public function discountOffer()
    {
        return $this->belongsTo(DiscountOffer::class);
    }
}