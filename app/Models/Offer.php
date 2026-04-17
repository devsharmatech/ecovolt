<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'amount',
        'status',
        'description',
        'valid_until'
    ];

    protected $casts = [
        'valid_until' => 'date',
        'amount' => 'decimal:2'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}