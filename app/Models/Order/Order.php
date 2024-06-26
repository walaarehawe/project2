<?php

namespace App\Models\Order;

use App\Models\Table\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\table;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $guarded =[];
    public function orderDetalis(){
        return $this->hasMany(OrderDetalis::class);
        }
    public function orderExternal(){
        return $this->hasOne(OrderExternalUser::class,'order_id');
        }
    public function table(){
        return $this->hasOne(OrderTable::class);
        }
}
