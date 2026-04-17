<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolarPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'price_per_kw',
        'gst_rate',
        'margin_floor'
    ];
}
