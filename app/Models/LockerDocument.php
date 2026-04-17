<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LockerDocument extends Model
{
    protected $fillable = [
        'user_id',
        'category',
        'title',
        'file_path',
        'file_type',
        'file_size'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
