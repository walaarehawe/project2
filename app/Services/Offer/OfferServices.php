<?php

namespace App\Services\Offer;

use App\Models\Offers\Offer;
use App\Models\Offers\Offer_detalis;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\Order\OrderOffer;
use App\Models\ProductType;
use Illuminate\support\facades\DB;
use App\Services\CRUDServices;
use GuzzleHttp\Psr7\Request;

class OfferServices  extends CRUDServices
{

    public function __construct()
    {
        parent::__construct(new Offer());
    }





    public function store($request)
    {

        DB::beginTransaction();


        try {
            $offer = Offer::create([
                'name' => $request->name,
                'total_price' => $request->total_price,
                'start_datetime' => $request->start_datetime,
                'end_datetime' => $request->end_datetime,
            ]);
            $offerId = $offer->id;
            $this->storeOfferdetalis($request, $offerId);
            DB::commit();
            return ResponseService::success('offer added successfully');
        } catch (Throwable $exception) {
            DB::rollBack();
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }


    public function updateOffer($request)
    {

        $offer = Offer::find($request->id);
        $offer->update();
    }

    public function storeOfferdetalis($request, $offerId)
    {
        $offers = $request->input('offers');
        foreach ($offers as $offer) {

            $d = [
                'product_id' => $offer['product_id'],
                'offer_id' => $offerId,
                'amount' => $offer['amount'],
            ];

            $detalis = Offer_detalis::create($d);
        }
    }

  

    }

