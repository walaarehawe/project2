<?php

namespace App\Models\Address;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;
    protected $table='user_addresses';
  
    protected $fillable = ['user_id', 'address_id'];
    protected $hidden = ['created_at','updated_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    
    public function getAncestors()
    {
        $ancestors = collect([]);
        $parent = $this;
        while ($parent != null) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }
        return $ancestors[0];
    }

}
