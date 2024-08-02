<?php

namespace App\Models\Order;

use App\Models\Offers\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOffer extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function offer(){
        return $this->belongsTo(Offer::class,'offer_id');
    }
}
