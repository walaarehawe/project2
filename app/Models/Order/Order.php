<?php

namespace App\Models\Order;

use App\Models\Address\UserAddress;
use App\Models\Notes;
use App\Models\Offers\Offer;
use App\Models\Order\Notes as OrderNotes;
use App\Models\ProductType;
use App\Models\Table\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\table;

class Order extends Model
{
    use HasFactory;
   
    protected $table = 'orders';
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];
   

    public function orderDetalis()
    {
        return $this->hasMany(OrderDetalis::class);
    }
    public function productType()
    {
        return $this->belongsToMany(ProductType::class,'order_detalis','order_id','product_id');
    }
    public function orderExternal()
    {
        return $this->hasOne(OrderExternalUser::class, 'order_id');
    }
    public function table()
    {
        return $this->hasOne(OrderTable::class);
    }

    public function notes()
    {
        return $this->hasOne(OrderNotes::class);
    }
 

    // public function offers()
    // {
    //     return $this->hasMany(OrderOffer::class);
    // }
    public function offers()
    {
        return $this->belongsToMany(Offer::class,'order_offers','order_id','offer_id')->withPivot('amount');
    }



}
