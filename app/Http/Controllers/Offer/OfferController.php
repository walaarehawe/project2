<?php

namespace App\Http\Controllers\Offer;

use Throwable;
use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\Offers\Offer;
use Illuminate\Http\Request;
use App\Services\Offer\OfferServices;

class OfferController extends Controller
{

    private OfferServices  $offer;
    public function __construct(OfferServices $offer)
    {
        $this->offer = $offer;
    }
    
    public function index()
    {

        try {
            $offer = Offer::where('status_offer', 1)->get();
            return ResponseService::success($offer, 'االعروض المتاحة');
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }


    
    public function store(Request $request)
    {

        try {
            return  $id = $this->offer->store($request);
            ResponseService::success(" تم الطلب بنجاح ");
        } catch (Throwable $exception) {

            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }


        $data = $request->all();
        $offer = Offer::create($data);
        return $offer;
    }



    public function update(Request $request)
    {

        try {
            $data = $this->offer->update($request['id'], $request->all());
            return ResponseService::success(' ', ' تم التحديث بنجاح');
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }


    public function Delete(Request $request)
    {
        $data = $this->offer->delete($request);
        return ResponseService::success($data['message'], $data['data']);
    }



    public function search(Request $request)
    {
        try {
            $search = $request->input('search');
            $results = Offer::where('name', 'like', "%$search%")->get();
            return ResponseService::success($results, 'نتيجت البحث');
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
