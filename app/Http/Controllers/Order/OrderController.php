<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\Order\Order;
use App\Models\TypeOrder;
use Throwable;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $order = Order::whereIn('type_id', [2, 3])
                ->where('status_invoice', 0)
                ->get();
            return ResponseService::success($order);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function orderLocal(Request $request)
    {
        try {
            $order = Order::where('type_id', 3)
                ->where('status_invoice', 0)
                ->get();
            return ResponseService::success($order);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function orderExternal(Request $request)
    {
        try {
            $order = Order::where('type_id', 2)
                ->where('status_invoice', 0)
                ->get();
            return ResponseService::success($order);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
