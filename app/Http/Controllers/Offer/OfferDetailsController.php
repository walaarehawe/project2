<?php

namespace App\Http\Controllers\Offer;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\Offers\Offer;
use App\Models\Offers\Offer_detalis;
use App\Services\Offer\OfferDetalisServices;
use Throwable;
use Illuminate\Http\Request;

class OfferDetailsController extends Controller
{
    private OfferDetalisServices $OfferDetalis;
  
    public function __construct( OfferDetalisServices $offer)
    {
        $this->OfferDetalis = $offer;
    }
    public function index()
    {
        return   $offers = Offer::whereHas('productTypes', function ($query) {
            $query->whereHas('offer', function ($query) {
                $query->where('status_offer', 1); // شرط على حالة العرض
            });
        })
            ->with(['productTypes' => function ($query) {
                $query->whereHas('offer', function ($query) {
                    $query->where('status_offer', 1); // شرط على حالة العرض
                });
            }])
            ->get();
    }
   


   
    public function show(Request $request)
    {
        
         $user = Offer::find($request->id);
        if(!$user->details1()->exists()){
            return 'العرض لا يتضمن تفاصيل';
        }
        
        return $user->details1;
    }

   
    public function update(Request $request)
    {

        try{
            $data = $this->OfferDetalis->update($request['id'] , $request->all());
            return ResponseService::success(' ' , ' تم التحديث بنجاح');
           }
            catch (Throwable $exception) {
            return ResponseService::error( $exception->getMessage() , 'An error occurred');
           }
    }

    public function Delete(Request $request){
        $data =$this->OfferDetalis->delete($request);
        return ResponseService::success($data['message'] , $data['data']);
      }
}
