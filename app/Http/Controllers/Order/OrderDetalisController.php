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
         $orders= Order::where('status_invoice', '0')
            ->whereHas('orderExternal', function ($query) use ($userId) {
                $query->whereHas('userAddress', function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId);
                });
            })
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
            ])->find($request->order_id);
            
            if (!$order) {
                return 'Order not found';
            }
            
            $response = [
                'offer'=>$order->offers
            ];
            foreach ($order->orderDetalis as $detail) {
                $productType = $detail->productType;
                $product = $productType->product;
               
                $response[] = [
                    'order_number' => $order->id,
                    'detalis_id' => $detail->id,
                    'product_type_name' => $productType->name,
                    'Calories' => $productType->Calories,
                    'amount' => $detail->amount,
                    'price_pre_one' => $detail->price_pre_one,
                    'total_price' => $detail->total_price,
                    'product_information' => $product->product_information,
                    'product_image' => $product->product_path,  
                    
                ];
            }
            $response['total_price']=$order->price;
          
            
            return $response;

            return ResponseService::success($order);
        } catch (Throwable $exception) {

            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
