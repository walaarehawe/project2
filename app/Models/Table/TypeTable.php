<?php

namespace App\Models\Table;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeTable extends Model
{
    use HasFactory;
    protected $table = 'table_types';
    protected $guarded =[];
    public function tableInternal(){
       return $this->hasMany(Table::class,'type_id');
    }
}
