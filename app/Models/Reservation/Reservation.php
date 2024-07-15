<?php

namespace App\Models\Reservation;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $guarded =[];
    // public function Type()
    // {
    //     return $this->belongsTo(TableReservations::class, '_id');
    // }
    public function Type()
    {
        return $this->hasMany(TableReservations::class);
    }
  
    public function time()
    {
        return $this->belongsTo(Time::class, 'time_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select(['id','name','phone']);
    }
}
