<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\Order\Order;
use App\Models\Order\OrderOffer;
use Illuminate\Http\Request;
use Throwable;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsSuccessful;

class OrderSearchController extends Controller
{
    public function search(Request $request)
    {

        try {
            $orders = Order::find($request->id);
            return ResponseService::success($orders);
        } catch (Throwable $exception) {

            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public static function calculateTotalPrice(Request $request)
    {
  
    
    }
}
