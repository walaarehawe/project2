<?php

namespace App\Models;

use App\Models\Offers\Offer;
use App\Models\Offers\Offer_detalis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\OrderDetalis;
class ProductType extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    protected $guarded =[];
    protected $table = 'product_types';
    use HasFactory;
    protected $hidden =['created_at','updated_at','product_id'];

    // public function products()
    // {
    //     return $this->belongsTo(Product::class);
    // }
    public function orderDetalis()
    {
        return $this->hasMany(OrderDetalis::class);
    }
    
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function offerDetails()
    {
        return $this->hasMany(Offer_detalis::class);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_detalis');
    }

}
