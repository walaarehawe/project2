<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Address\Address;
use App\Models\Address\UserAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at','updated_at'

    ];
 

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function address(){
        return $this->hasMany(UserAddress::class);
    }
    public function addresses()
{
    return $this->hasMany(UserAddress::class, 'user_id')->with('address.childAddresses');
}

public function childAddresses()
{
    return $this->hasMany(UserAddress::class, 'user_id')->with('address.childAddresses');
}


public function deviceTokens(){
    return $this->hasMany(DeviceToken::class);
}
public function routeNotificationForFcm(){
    return $this->deviceTokens()->pluck('device_token')->toArray();
}
}
