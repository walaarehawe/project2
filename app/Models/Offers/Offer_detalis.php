<?php

namespace App\Models\Offers;

use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer_detalis extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function offer(){
        return $this->belongsTo(Offer::class);
    }
    public function productType(){
        return $this->belongsTo(ProductType::class,'product_id');
    }
}
