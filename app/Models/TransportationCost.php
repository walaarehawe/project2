<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportationCost extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function transport()
    {
        return $this->belongsTo(Transport::class);
    }
}
