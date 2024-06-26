<?php

namespace App\Models\Table;

use App\Enums\InvoiceStatus;
use App\Models\Order\OrderTable;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function order(){
        return $this->hasOne(OrderTable::class)->whereHas('order', function ($query) {
            $query->where('status_invoice', '!=', InvoiceStatus::PAID);
        });   
    }

}
