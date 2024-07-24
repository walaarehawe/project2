<?php

namespace App\Models\Order;

use App\Models\Address\Address;
use App\Models\Address\Street;
use App\Models\Address\UserAddress;
use App\Models\TransportationCost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderExternalUser extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id');
    }
    public function adder()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function userAddress()
    {
        return $this->belongsTo(UserAddress::class);
    }
    public function transportcost()
    {
        return $this->belongsTo(TransportationCost::class, 'trnsporation_costs_id','id');
    }
}
