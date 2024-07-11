<?php

namespace App\Http\Controllers\WaiterSystem;

use App\Http\Controllers\Controller;
use App\Models\Waiter;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class WaiterController extends Controller
{
    public function ss(Request $request){
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
