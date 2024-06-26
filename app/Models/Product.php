<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $casts = [
        'total_ratings' => 'double',
    ];
     public function ProductType()
    {
        return $this->hasMany(ProductType::class);
    }

 

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}

