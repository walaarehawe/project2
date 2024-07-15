<?php

namespace App\Http\Controllers\Casher;

use App\Enums\InvoiceStatus;
use App\Enums\OrderType;
use App\Enums\StatusTable;
use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Controller;
use App\Models\Table\Table;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use App\Models\Product;
use Throwable;
use App\Services\invoice\InvoiceServices;
use App\HTTP\Responses\ResponseService;
use App\Models\Address\UserAddress;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    private InvoiceServices  $invoice;


    public function __construct(InvoiceServices $invoice)
    {
        $this->invoice = $invoice;
    }

    public function showInvoiceTable(Request $request)
    {
        try {
            $invoice = $this->invoice->showInvoiceTable($request);
            return ResponseService::success('da', $invoice);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function showInvoiceOrderNumber(Request $request)
    {
        try {
            return $data =  $this->invoice->showInvoiceOrderNumber($request);
            return ResponseService::success('da', $data);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }


    public function update(Request $request)
    {
        try {
            $success = $this->invoice->updatePayment($request);
            return ResponseService::success(' تم الدفع بنجاح');
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function invoiceInternal(Request $request)
    {
        try {
            $invoice = Order::where('status_invoice', 1)->where('type_id', 1)->get();
            return ResponseService::success($invoice);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function invoiceExternal(Request $request)
    {
        try {
            $invoice = Order::where('status_invoice', 1)->where('type_id', 2)->get();
            return ResponseService::success($invoice);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function invoiceLocal(Request $request)
    {
        try {
            $invoice = Order::where('status_invoice', 1)->where('type_id', 3)->get();
            return ResponseService::success($invoice);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
