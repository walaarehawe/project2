<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded =[];

    // public function transports()
    // {
    //     return $this->belongsToMany(Transport::class, 'employee_transports');
    // }
    
    public function transports()
    {
        return $this->hasOne(Employee_transport::class);
    }
 
}
