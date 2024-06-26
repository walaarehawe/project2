<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTable extends Model
{
    use HasFactory;
    //protected $table = 'orders';
    protected $guarded =[];
    public function order(){
        return $this->belongsTo(order::class);
    }
}
