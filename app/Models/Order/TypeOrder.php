<?php

namespace App\Models\Order;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOrder extends Model
{
    use HasFactory;
    public function order(){
        return $this->hasmany(Order::class,'type_id')->where('status_invoice',0);
    }
}
