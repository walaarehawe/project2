<?php

namespace App\Models;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waiter extends Model
{
    use HasFactory;
    protected $guarded =[];
    // public function order()
    // {
    //     return $this->hasMany(Order::class);
    // }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }
}
