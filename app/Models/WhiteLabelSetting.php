<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteLabelSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'logo_url',
        'primary_color',
        'secondary_color',
        'subdomain_prefix',
        'welcome_email_template',
        'password_reset_email_template',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}