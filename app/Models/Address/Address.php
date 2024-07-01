<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table='addresses';
    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Address::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Address::class, 'parent_id');
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
