<?php

namespace App\Models\Offers;

use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $hidden = ['pivot','created_at','updated_at','end_datetime','start_datetime','status_offer'];

    public function offerDetails()
    {
        return $this->hasMany(Offer_detalis::class);
    }

    public function productTypes()
    {
        
        return $this->belongsToMany(Offer_detalis::class);
    }
    public function details()
    {
        return $this->hasMany(Offer_detalis::class, 'offer_id');
    }
    public function details1()
    {
        return $this->belongsToMany(ProductType::class,'offer_detalis','offer_id','product_id');
    }
}