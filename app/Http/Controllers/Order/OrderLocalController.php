<?php

namespace App\Http\Controllers\Order;

use App\Enums\InvoiceStatus;
use App\Models\Order\Order;
use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Models\Order\OrderDetalis;
use Illuminate\Http\Request;
use App\Services\Order\OrderLocalService;

class OrderLocalController extends Controller
{

  private OrderLocalService  $order;


  public function __construct(OrderLocalService $order)
  {
    $this->order = $order;
  }
  public function store(Request $request)
  {
    return     $order_id = $this->order->store($request);
  }
}
