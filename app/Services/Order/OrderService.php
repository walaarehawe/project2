<?php

namespace App\Services\Order;

use App\Models\Offers\Offer;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use App\Models\Order\OrderOffer;
use App\Models\ProductType;
use App\Services\CRUDServices;


class OrderService extends CRUDServices
{
    public static function calculateTotalPrice($id_order, $priceCost = 0)
    {
        $orderdetalis = OrderDetalis::where('order_id', $id_order)->get();
        $i = 0;
        $sum = 0;

        foreach ($orderdetalis as $order) {
            $d[] = $orderdetalis[$i]->total_price;
            $sum += $d[$i];
            $i++;
        }
        $priceOffer = OrderOfferServices::calculateTotalPrice($id_order);
        $orderprice = Order::find($id_order);
        $totalSum = $sum + $priceOffer + $priceCost;
        $orderprice->update(['price' => $totalSum]);
    }

    public static function addDetalisToOrder($request, $id)
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
}
