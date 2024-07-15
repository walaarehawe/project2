<?php

namespace App\Services\Waiter;

use App\Models\User;
use App\Models\Waiter;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class WaiterServices
{
  public function ss($request){
    $waiters=  Role::where('name', 'customer')->first()->users()->with('Employee')->get();
 foreach($waiters as $waiter){
 if(!$waiter->Employee->active){
     $array[] = $waiter->id;
 }}

  $last = Waiter::orderBy('id', 'DESC')->first();
  $index = array_search($last->waiter_id, $array);
if(count($array)>$index+1){
    $request['waiter_id'] = $array[$index+1];
}
else {
    $request['waiter_id'] =   $array[0];

}
return $rr =Waiter::create($request->all()); 
}


  }

