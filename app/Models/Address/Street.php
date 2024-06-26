<?php

namespace App\Models\Address;

use App\Models\Order\OrderExternalUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;
    protected $guarded =[];
  
public function region(){
    return $this->belongsTo(Region::class);
}
}
