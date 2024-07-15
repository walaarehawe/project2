<?php

namespace App\Services\Order;

use App\Models\Offers\Offer;
use App\Models\Order\OrderOffer;
use App\Services\CRUDServices;


class OrderOfferServices extends CRUDServices
{

  public static function storeOrderOffer($request, $id)
  {
    $offers = $request->input('offers');
    foreach ($offers as $offer) {

     
    $offers = Offer::find($offer['offer_id']);

      if ($offers) {
        OrderOffer::create([
          'order_id' => $id,
          'offer_id' => $offers->id,
          'amount'=>$offer['amount']
        ]);
      }
    }
  }
  public static function calculateTotalPrice($OrderID)
  {

    $orders = OrderOffer::with('offer')->where('order_id', $OrderID)->get();
      $sum = 0;
      foreach ($orders as $order) {
        $price =  $order->offer->total_price*$order->amount;
        $sum += $price;
      }
      return $sum;
  }
}
