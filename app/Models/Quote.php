<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'user_id', 'project_id', 'proposal_id', 'package_name', 'total_price', 
        'status', 'components', 'timeline', 'quote_date', 'rejection_reason'
    ];

    protected $casts = [
        'components' => 'array',
        'total_price' => 'decimal:2',
        'quote_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
