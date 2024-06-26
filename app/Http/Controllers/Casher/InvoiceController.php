<?php

namespace App\Http\Controllers\Casher;

use App\Enums\InvoiceStatus;
use App\Enums\OrderType;
use App\Enums\StatusTable;
use App\Http\Controllers\Controller;
use App\Models\Table\Table;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use App\Models\Product;
use Throwable;

use App\HTTP\Responses\ResponseService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
   
    
    public function showInvoiceTable(Request $request)
    {
        try {
            $table = Table::find($request->tableID);
            if ($table->order === null) {
                return " الطاولة ليست لها طلبية";
            }
            $orderID = $table->order->order_id;
            $order = Order::find($orderID);
            $orderDetails = $order->orderDetalis()->with('productType')->get();
            $orderDetails['total_price_order'] = $order->price;
            return ResponseService::success('da', $orderDetails);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function showInvoiceOrderNumber(Request $request)
    {
        try {

            $order_id = $request->order_id;
            $order = Order::find($order_id);

            if ($order->type_id == OrderType::LOCAL) {
                $d = $order->orderDetalis()->with('productType')->get();
                $d['total_price_order'] = $orderDetails['total_price_order'] = $order->price;
                return $d;
            }

            if ($order->type_id == OrderType::EXTERNAL) {
                // $d= $order->orderDetalis()->with('productType')->get();
                return Order::with(
                    'orderDetalis.productType',
                    'orderExternal.user',


                )->find($order_id);
                $d['total_price_order'] = $orderDetails['total_price_order'] = $order->price;
                return $d;
                $orderDetails['total_price_order'] = $order->price;
            } else {
                return 'not found';
            }
            $orderDetails = $order->orderDetalis()->with('productType.product')->get();
            $orderDetails['total_price_order'] = $order->price;
            return ResponseService::success('da', $orderDetails);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }


    public function update(Request $request)
    {
        try {
            $order =  Order::find($request->order_id);
            if ($order->type_id == OrderType::INTERNAL) {
                $table_id = $order->table->table_id;
                if ($order->status_invoice == InvoiceStatus::UNPAID) {
                    $order->update([
                        'status_invoice' => InvoiceStatus::PAID,
                    ]);

                    $table = Table::find($table_id);
                    $table->update([
                        'reservation_status' => StatusTable::NON_RESERVED,
                    ]);
                    return ResponseService::success(' تم الدفع بنجاح');
                }
            } else {
                if ($order->status_invoice == InvoiceStatus::UNPAID) {
                    $order->update([
                        'status_invoice' => InvoiceStatus::PAID,
                    ]);
                    return ResponseService::success(' تم الدفع بنجاح');
                }
            }
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }

   
    
}
