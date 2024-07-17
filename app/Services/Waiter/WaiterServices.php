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
    // $array;
    foreach($waiters as $waiter){
 if($waiter->Employee->active){
   $array[] = $waiter->id;
 }}
//  $request['jobs'] = 0;

  $last = Waiter::where('jobs',$request->jobs)->orderBy('id', 'DESC')->first();
  // return ["",$last];
  $index=-1;
  if($last){
  $index = array_search($last->waiter_id, $array);}
// echo 1;
  if(count($array) > $index+1){

    $request['waiter_id'] = $array[$index+1];
}
else {
     $request['waiter_id'] =   $array[0];

}

return  $rr =Waiter::create($request->all()); 

}





  }

