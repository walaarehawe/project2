<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderType;
use Throwable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use App\HTTP\Responses\ResponseService;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use Illuminate\support\facades\DB;
use App\Models\Order\OrderTable;
use App\Models\Product;
use App\Models\ProductType;
use App\Services\CRUDServices;
use App\Services\Order\OrderInternalService;
use function Laravel\Prompts\table;

class OrderInternalController extends Controller
{
  private OrderInternalService $order;

  public function __construct(OrderInternalService $order)
  {
    $this->order = $order;
  }

  public function store(Request $request)
  {

    try {
      $id = $this->order->order2($request);
      if ($id == 'errotable') {
        return ResponseService::error("error is happen table not found", "");
      }
      if ($id == 'product not found') {
        return ResponseService::error("product not found", "");
      }
      return ResponseService::success(" تم الطلب بنجاح ");
    } catch (Throwable $exception) {

      return ResponseService::error($exception->getMessage(), 'An error occurred');
    }
  }



  public function on()
  {
    $product = ProductType::find(1);
    $pro = $product->Product;
    return $pro['product_name'];
  }
  public function product()
  {
    //  $product= Product::select()
    // return $product = Product::with('ProductType')->select('id', 'product_name as product_n')->get();

    return $product = Product::with(['ProductType' => function ($query) {
      $query->select('id', 'name as name_product_type', 'price', 'product_id');
    }])
      ->select('id', 'product_name as name_product')
      ->get();
  }
  public function ex(Request $request){
    $products = $request->input('products');
    foreach ($products as $product) {

    $product_id=  ProductType::where('name', $product['product_name'])->first();
    return $product_id->id;
    }
  }
}
