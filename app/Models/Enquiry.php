<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'address',
        'load_requirement',
        'panel_capacity',
        'package_name',
        'site_photo',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
