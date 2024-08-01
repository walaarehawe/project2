<?php

namespace App\Http\Controllers\WaiterSystem;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\Order\Order;
use App\Models\Waiter;
use App\Models\User;
use App\Services\Waiter\WaiterServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Throwable;
class WaiterController extends Controller
{
    private     WaiterServices $waiterServices;
    public function __construct(WaiterServices $waiterServices)
    {
        $this->waiterServices = $waiterServices;

    }
    public function ss(Request $request){

        try {
            $data = $this->waiterServices->ss($request);
           return ResponseService::success("show succ",$data);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
}
public function show(Request $request){

    try {

 $user =Auth::id();
return $order = Waiter::with('order.table')->where('waiter_id',$user)->get();
    } catch (Throwable $exception) {
        return ResponseService::error($exception->getMessage(), 'An error occurred');
    }
}


public function showdel(Request $request){

    try {

 $user =Auth::id();
return $order = Waiter::with('order.orderExternal.userAddress')->where('waiter_id',$user)->get();
    } catch (Throwable $exception) {
        return ResponseService::error($exception->getMessage(), 'An error occurred');
    }
}




public function changestatus(Request $request)
{

    try {
        $order = Order::find($request->id);
        $order->update([
            'status_order' => OrderStatus::delivered,
        ]);
        return ResponseService::success("order delivered succ", $order);
    } catch (Throwable $exception) {
        return ResponseService::error($exception->getMessage(), 'An error occurred');
    }
}
public function SelectDelevary(Request $request){
     $waiters=  Role::where('name', 'delivery')->first()->users()->with('Employee.transports')->get();
    // $array[] = null;
    foreach($waiters as $waiter){
    if($waiter->Employee->active !=null && $waiter->Employee->transports->transport_id==$request->transport_id){
   $array[] = $waiter->id;
  }}
  $lastwaiter = null;
   $lasts = Waiter::with('user.employee.transports')->where([['jobs',$request->jobs]])->orderBy('id', 'DESC')->get();
 foreach($lasts as $last){
    if( $last->user->Employee->transports->transport_id==$request->transport_id){
    $lastwaiter = $last->user->id;
    break;}
  }
  $index=-1;
  if($lastwaiter ){
  $index = array_search($lastwaiter, $array);}
//   echo $index+1;
  if(count($array) > $index+1){
    $request['waiter_id'] = $array[$index+1];

}
  else {
     $request['waiter_id'] =   $array[0];
  }
  return  $rr =Waiter::create($request->all(['waiter_id','jobs' , 'order_id'])); 
  }
  
  
  
  
  
}
