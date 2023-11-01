<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements HasMedia, FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia ;



    public function canAccessFilament(): bool
    {
        return str_ends_with($this->email, '.com');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'user_data_is_verified' => 'boolean'
    ];

    protected $appends = ['phone_is_verified'];


    public function getPhoneIsVerifiedAttribute()
    {
        return !is_null($this->phone_verified_at);
    }



    public function roles() {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function drivers(): HasMany
    {
        return $this->hasMany(Driver::class , 'carrier_id');
    }

    public function carrier(): HasOne
    {
        return $this->hasOne(CarrierLegal::class , 'user_id');
    }







}
