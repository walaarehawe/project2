<?php

namespace App\Services\Order;

use App\Enums\OrderType;
use App\Enums\StatusTable;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\Notes;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use Illuminate\support\facades\DB;
use App\Models\Order\OrderTable;
use App\Models\ProductType;
use App\Models\Table\Table;
use App\Services\CRUDServices;

class OrderInternalService extends CRUDServices
{
    public function __construct()
    {
        parent::__construct(new Order());
    }




    public function o($request)
    {
        $table_number = $request->input('table_number');
        $table = Table::find($table_number);
        if (!$table) {
            return 'errotable';
        }

        if ($table->reservation_status == StatusTable::NON_RESERVED) {

            // $data2 = $request->all;
            $data2['type_id'] = OrderType::INTERNAL;
            $order = Order::create($data2);
            $id = $order->id;

            $table->update(['reservation_status' => StatusTable::RESERVED]);
            $order2 = OrderTable::create(
                [
                    'order_id' => $id,
                    'table_id' => $table_number,
                ]
            );
        } else {
            $id = $table->order->order_id;
        }
        return $id;
    }




    public function order2($request)
    {
        DB::beginTransaction();
        try {
            $id = $this->o($request);
            if ($id == 'errotable') {
                return 'errotable';
            }
            if ($request->input('offers')) {
                OrderOfferServices::storeOrderOffer($request,  $id);
            }
            if ($request->notes) {
                Notes::create([
                    'notes' => $request->notes,
                    'order_id' => $id,
                ]);
            }
            if ($request->input('products')) {
                $order_detalis =   OrderService::addDetalisToOrder($request, $id);
                if ($order_detalis == 'product not found') {
                    return 'product not found';
                }
            }
            OrderService::calculateTotalPrice($id);
            DB::commit();
            return ResponseService::success('Order placed successfully');
        } catch (Throwable $exception) {
            DB::rollBack();
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
} 













// namespace App\Services\Order;

// use App\Enums\OrderType;
// use App\Enums\StatusTable;
// use Throwable;
// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use Illuminate\Http\ResponseTrait;
// use App\HTTP\Responses\ResponseService;
// use App\Models\Order\Order;
// use App\Models\Order\OrderDetalis;
// use Illuminate\support\facades\DB;
// use App\Models\Order\OrderTable;
// use App\Models\Product;
// use App\Models\ProductType;

// use App\Models\TypeOrder;
// use Illuminate\Http\JsonResponse;

// use App\Models\Section;
// use App\Models\Table\Table;
// use App\Services\CRUDServices;
// use Spatie\Permission\Models\Role;
// use Illuminate\Support\Facades\Hash;

// class OrderInternalService extends CRUDServices
// {
//     public function __construct()
//     {
//         parent::__construct(new Order());
//     }

//     public function rule($request, $id, $price_pre_one)
//     {
//         $total_price = $request->amount * $price_pre_one;

//         return $datau = [
//             'order_id' => $id,
//             'product_id' => $request->product_id,
//             'amount' => $request->amount,
//             'price_pre_one' => $price_pre_one,
//             'total_price' => $total_price
//         ];
//       // $total_price = $request->amount * $price_pre_one;

//         // return $datau = [
//         //     'order_id' => $id,
//         //     'product_id' => $request->product_id,
//         //     'amount' => $request->amount,
//         //     'price_pre_one' => $request->price_per_one,
//         //     'total_price' => $request->total_price
//         // ];
//     }
//     public function calculateTotalPrice($id_order)
//     {
//         $orderdetalis = OrderDetalis::where('order_id', $id_order)->get();
//         $i = 0;
//         $sum = 0;

//         foreach ($orderdetalis as $order) {
//             $d[] = $orderdetalis[$i]->total_price;
//             $sum += $d[$i];
//             $i++;
//         }
//         $orderprice = Order::find($id_order);
//         $orderprice->update(['price' => $sum]);
//     }





//     // public function table($id,  $request)
//     // {

//     //     $table = Table::find($request->table_id);
//     //     if ($table->status == StatusTable::NON_RESERVED) {
//     //         $table->update(['status' => StatusTable::RESERVED]);
//     //         $table_id = $request->table_id;
//     //         $order2 = OrderTable::create(
//     //             [
//     //                 'order_id' => $id,
//     //                 'table_id' => $table_id,
//     //             ]
//     //         );
//     //     } else {
//     //         return $table->order->id;
//     //     }
//     // }
//     public function o($request)
//     {
//         $table = Table::find($request->table_id);

//         if ($table->reservation_status == StatusTable::NON_RESERVED) {

//             $data2 = $request->all;
//             $data2['type_id'] = OrderType::INTERNAL;
//             $order = Order::create($data2);
//             $id = $order->id;

//             $table->update(['reservation_status' => StatusTable::RESERVED]);
//             $order2 = OrderTable::create(
//                 [
//                     'order_id' => $id,
//                     'table_id' => $request->table_id,
//                 ]
//             );
//         } else {
//             ////////////////////////

//             $id = $table->order->order_id;
//         }
//         return $id;
//     }
//     public function addDetalisToOrder($request, $id)
//     {
//         $pei = ProductType::where('id', $request->product_id)->get();
//         $price_pre_one = $pei[0]->price;
//         $detalis = OrderDetalis::create($this->rule($request, $id, $price_pre_one));
//         return $detalis;
//     }
//     public function order2($request)
//     {
//         // event (new eventforwaiter($detalis));

//         // يقوم بالتحقق اذا كانت الطاولة مشغولة او لا واذا كانت مشغولة معناها في عليها 
//         //     المفروض يتم مربوط مع الطاولة لحتى تندفع الطلبية id    ف انا هاد ال  id   طلبية وهي الطلبيبة الها 
//         // طيب اجيت انا طلبت طلبية وانا قاعد ع طاولة معينة فرجعت وطلبت مرة تانية فالمفرض انو
//         // id ينضافو ع نفس ال طلبية اللي انا شغال فيا مشان يطلع بس فاتورة واحدة يعني كل طاولة لها طلبية واحدة بنفس ل 
//         // لكن الطلبية قابلة للزيادة فعند الطلب مرة اخرى يضاف ايضا الى نفس الطلبية
//         //  مشان اعرف ع اي طلبية لازم ضيف التفاصيل او اني انشا طلبية جديدة  id_orderالمهم هاد التابع بس برجع        
//         //     مشان ضيف عليه تفاصيل الطلبية id   وبكلا الحالتين انا محتاج هاد ال  
//         try {
//             $id = $this->o($request);
//             // اضافة تفاصيل الطلبية 
//             $this->addDetalisToOrder($request, $id);
//             //// تعديل سعر ال الطلبية الكلي عند الطلب باالاعتماد على ال orderDetalis;
//             $this->calculateTotalPrice($id);
//         } catch (Throwable $exception) {
//             return ResponseService::error($exception->getMessage(), 'An error occurred');
//         }
//     }
// } 
