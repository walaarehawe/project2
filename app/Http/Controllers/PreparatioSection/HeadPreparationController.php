<?php

namespace App\Http\Controllers\PreparatioSection;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order\Order;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\Order\OrderDetalis;
use PhpParser\Node\Stmt\Return_;

class HeadPreparationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function ex(Request $request)
    {

        $products = $request->input('products');

        foreach ($products as $product) {
            $total_price = $product['price_per_one'] * $product['amount'];
       return     $d = [
                'product_id' => $product['product_id'],
                'amount' => $product['amount'],
                'price_pre_one' => $product['price_per_one'],
                'order_id' => 31,
                'total_price' => $total_price,
            ];
           
        }

     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        try {
            $order = Order::find($request->id);
            $order->update([
                'status_order' => OrderStatus::READY,
            ]);
            return ResponseService::success('تم تاكيد تجهيز الطلبية بنجاح بنجاح', " ");
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
