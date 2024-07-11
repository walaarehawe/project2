<?php

namespace App\Services\Offer;
use App\Models\Offers\Offer;
use App\Models\Offers\Offer_detalis;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\ProductType;
use Illuminate\support\facades\DB;
use App\Services\CRUDServices;
use GuzzleHttp\Psr7\Request;

class OfferDetalisServices  extends CRUDServices
{

    public function __construct()
    {
        parent::__construct(new Offer_detalis());
    }
  
}

