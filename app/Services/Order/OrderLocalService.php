<?php

namespace App\Services\Order;

use App\Enums\InvoiceStatus;
use App\Enums\OrderType;
use App\Enums\StatusTable;
use Throwable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use App\HTTP\Responses\ResponseService;
use App\Models\Notes;
use App\Models\Order\Notes as OrderNotes;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use Illuminate\support\facades\DB;
use App\Models\Order\OrderTable;
use App\Models\Product;
use App\Models\ProductType;

use App\Models\TypeOrder;
use Illuminate\Http\JsonResponse;

use App\Models\Section;
use App\Models\Table\Table;
use App\Services\CRUDServices;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class OrderLocalService extends CRUDServices
{
    public function __construct()
    {
        parent::__construct(new Order());
    }



    public function addDetalisToOrder($request, $id)
    {

        $products = $request->input('products');

        foreach ($products as $product) {
            $total_price = $product['price_per_one'] * $product['amount'];
            $d = [
                'product_id' => $product['product_id'],
                'amount' => $product['amount'],
                'price_pre_one' => $product['price_per_one'],
                'order_id' => $id,
                'total_price' => $total_price,
            ];
            $detalis = OrderDetalis::create($d);
        }
    }




    public function store($request)
    {
        DB::beginTransaction();

        try {
            $data2['type_id'] = OrderType::LOCAL;
            $order = Order::create($data2);
            $order_id = $order->id;
            if ($request->input('offers')) {
                OrderOfferServices::storeOrderOffer($request, $order_id);
            }
            if ($request->notes) {
                OrderNotes::create([
                    'notes' => $request->notes,
                    'order_id' => $order_id,
                ]);
            }
            if ($request->input('products')) {
                $this->addDetalisToOrder($request, $order_id);
            }
            OrderService::calculateTotalPrice($order_id);
            Db::commit();
            return ResponseService::success('Order placed successfully');
        } catch (Throwable $exception) {
            DB::rollBack();
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
