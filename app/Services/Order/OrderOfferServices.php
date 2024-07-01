<?php

namespace App\Services\Order;

use App\Models\Offers\Offer;
use App\Models\Order\OrderOffer;
use App\Services\CRUDServices;


class OrderOfferServices extends CRUDServices
{
   
    public static function storeOrderOffer($request,$id)
{
    $offers = $request->input('offers');
            foreach ($offers as $offer) {
           
              $offer=Offer::find($offer['offer_id']);

            if($offer){
                 OrderOffer::create([
                    'order_id'=>$id,
                    'offer_id'=> $offer->id,
                ]);
              }
            }
}
}
