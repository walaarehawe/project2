<?php

namespace App\Models\Order;

use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetalis extends Model
{
    use HasFactory;
 //   protected $table="product_types";
    protected $guarded =[];
    protected $hidden =['created_at','updated_at'];
    public function product(){
        return $this->belongsTo(ProductType::class)->select('id', 'name as name_product_type');
    }
    // public function productgh(){
    //     return $this->belongsTo(ProductType::class)->select('id', 'name as name_product_type');
    // }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_id');
    }
}
