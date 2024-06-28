<?php

namespace App\Models\Reservation;

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
}
