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


}
