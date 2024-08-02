<?php

namespace App\Http\Controllers\Order;


use Throwable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use App\HTTP\Responses\ResponseService;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Auth;

class OrderDetalisController extends Controller
{
    // public function getUnpaidOrdersByUserId(Request $request)
    // {
    //    $userId= $request->user_id;
    //     // استعلام لجلب جميع الطلبيات غير المدفوعة للمستخدم المعين
    //     $orders = Order::where('status_invoice', '0') // الطلبيات غير المدفوعة
    //         ->whereHas('orderExternal', function ($query) use ($userId) {
    //             $query->whereHas('userAddress', function ($subQuery) use ($userId) {
    //                 $subQuery->where('user_id', $userId);
    //             });
    //         })
    //         ->with([
    //             'orderDetalis.productType',
    //             'offers',
    //         ])
    //         ->get();
    //         unset($orders['status_invoice']);
    //         unset($orders['order_detalis.product_type.category_id']);
    //         return $orders;
    // }
    public function getUnpaidOrdersByUserId(Request $request)
    {

        try {
            $userId = Auth::id();
            $orders = Order::whereHas('orderExternal', function ($query) use ($userId) {
                $query->whereHas('userAddress', function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId);
                });
            })->orderBy('created_at', 'desc')
                ->select('id', 'type_id', 'price', 'status_invoice') // تحديد الحقول التي ترغب في عرضها
                ->get();

            return ResponseService::success($orders);
        } catch (Throwable $exception) {

            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }

    public function orderDetalis(Request $request)
    {
        try {
            $order = Order::with([
                'orderDetalis.productType.product',
                'offers',
                'orderExternal.transportcost.transport',
            ])->find($request->order_id);

            $transportCost = $order->orderExternal->transportcost;
            unset($order->orderExternal);
            // $transport = $transportCost->transport;

            // قم بإرجاع البيانات المطلوبة
            return ResponseService::success([
                'order' => $order,
                'transportcost' => $transportCost,
            ]);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
