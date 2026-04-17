<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    public function guardName()
    {
        return ['api', 'web'];
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'profile_picture',
        'status',
        'locality',
        'user_code',
        'consumer_id',
        'service_address',
        'otp',
        'is_verified',
        // Vendor Fields
        'business_name',
        'business_type',
        'gst_number',
        'pan_number',
        'business_address',
        'business_city',
        'business_state',
        'business_pincode',
        'bank_name',
        'account_number',
        'ifsc_code',
        'account_holder_name',
        'aadhar_card',
        'pan_card',
        'gst_certificate',
        'bank_passbook',
        'verification_status',
        'verification_notes',
        'business_description'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'dealer_id');
    }

    public function projects()
    {
        return $this->hasManyThrough(Project::class, Lead::class, 'dealer_id', 'lead_id');
    }
}
