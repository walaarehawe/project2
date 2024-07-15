<?php

namespace App\Services\invoice;

use App\Enums\InvoiceStatus;
use App\Enums\OrderType;
use App\Enums\StatusTable;
use App\Http\Controllers\Address\AddressController;
use App\Http\Responses\ResponseService;
use App\Models\Offers\Offer;
use App\Models\Order\Order;
use Throwable;
use App\Models\Order\OrderOffer;
use App\Models\Table\Table;
use App\Services\CRUDServices;


class InvoiceServices
{

    public static function storeOrderOffer($request, $id)
    {
    }
    public function showInvoiceTable($request)
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
            return  $orderDetails;
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function showInvoiceOrderNumber($request)
    {

        try {

            $order_id = $request->order_id;
            $order = Order::with('orderDetalis.productType', 'offers')->find($order_id);

            if (!$order) {
                return 'order not found';
            }
            if ($order->type_id == OrderType::LOCAL) {
                // $d = $order->orderDetalis()->with('productType','offers')->get();
                return $order;
                $d['total_price_order'] = $orderDetails['total_price_order'] = $order->price;
                return  $d;
            }

            if ($order->type_id == OrderType::EXTERNAL) {
                $data = $this->getadderss($request->order_id);
                return  $data;
            }
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function getadderss($id)
    {
        try {
            $order = Order::with([
                'orderDetalis.productType',
                'offers',
                'orderExternal.userAddress.user'
            ])->find($id);

            $addressName = $order->orderExternal->userAddress;
            $addressId = $addressName->address_id;
            $addressName['address'] = AddressController::showuseraddress($addressId);
            $orderArray = $order->toArray();
            unset($orderArray['order_external']);
            $data = [
                'name_address' => $addressName,
                'order' => $orderArray
            ];
            return $data;
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function updatePayment($request)
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
