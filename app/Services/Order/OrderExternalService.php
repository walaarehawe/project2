<?php

namespace App\Services\Order;

use App\Enums\OrderType;
use App\Enums\StatusTable;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\Address\Address;
use App\Models\Address\UserAddress;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use App\Models\Order\OrderExternalUser;
use Illuminate\support\facades\DB;
use App\Models\Order\OrderTable;
use App\Models\ProductType;
use App\Models\Table\Table;
use App\Services\CRUDServices;
use Illuminate\Support\Facades\Auth;

class OrderExternalService extends CRUDServices
{


    public function __construct()
    {
        parent::__construct(new Order());
    }
    public function calculateTotalPrice($id_order)
    {
        $orderdetalis = OrderDetalis::where('order_id', $id_order)->get();
        $i = 0;
        $sum = 0;

        foreach ($orderdetalis as $order) {
            $d[] = $orderdetalis[$i]->total_price;
            $sum += $d[$i];
            $i++;
        }
        $orderprice = Order::find($id_order);
        $orderprice->update(['price' => $sum]);
    }


    public function o($request)
    {
        // $data2 = $request->all;
        $data2['type_id'] = OrderType::EXTERNAL;
        $order = Order::create($data2);
        $id = $order->id;

        $user_id = Auth::id();
        $addressId = $request->address_id;
        $userAddress = UserAddress::where('address_id', $addressId)
            ->where('user_id', $user_id)
            ->first(); 
              


        $order2 = OrderExternalUser::create(
            [
                'order_id' => $id,
                'user_address_id' => $userAddress->id,
            ]
        );

        return $id;
    }
    public function addDetalisToOrder($request, $id)
    {

        $products = $request->input('products');
        foreach ($products as $product) {
            $product_id =  ProductType::where('name', $product['product_name'])->first();
            if (!$product_id) {

                return 'product not found';
            }
            $total_price = $product['price_per_one'] * $product['amount'];
            $d = [
                'product_id' => $product_id->id,
                'amount' => $product['amount'],
                'price_pre_one' => $product['price_per_one'],
                'order_id' => $id,
                'total_price' => $total_price,
            ];

            $detalis = OrderDetalis::create($d);
        }
    }
    public function order2($request)
    {
        DB::beginTransaction();
        $address = Address::find($request->address_id);
        if (!$address) {
            return 'address not found';
        }
        try {
            $id = $this->o($request);
            $order_detalis = $this->addDetalisToOrder($request, $id);
            if ($order_detalis == 'product not found') {
                return 'product not found';
            }
            if($request->input('offers')){
            OrderOfferServices::storeOrderOffer($request,  $id);
            }
            $this->calculateTotalPrice($id);
            DB::commit();
            return ResponseService::success('Order placed successfully');
        } catch (Throwable $exception) {
            DB::rollBack();
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
