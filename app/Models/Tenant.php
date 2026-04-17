<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'database',
        'is_active',
    ];

    // Relationship with WhiteLabelSetting
    public function whiteLabelSetting()
    {
        return $this->hasOne(WhiteLabelSetting::class);
    }
}