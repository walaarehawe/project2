<?php

namespace App\Services\Order;

use App\Enums\OrderType;
use App\Enums\StatusTable;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\Address\Address;
use App\Models\Address\UserAddress;
use App\Models\Notes;
use App\Models\Order\Notes as OrderNotes;
use App\Models\Order\Order;
use App\Models\Order\OrderDetalis;
use App\Models\Order\OrderExternalUser;
use Illuminate\support\facades\DB;
use App\Models\Order\OrderTable;
use App\Models\ProductType;
use App\Models\Table\Table;
use App\Models\TransportationCost;
use App\Services\CRUDServices;
use Illuminate\Support\Facades\Auth;

class OrderExternalService extends CRUDServices
{
    public $cost;

    public function __construct()
    {
        parent::__construct(new Order());
    }


    public function o($request)
    {
        $data2['type_id'] = OrderType::EXTERNAL;
        $order = Order::create($data2);
        $id = $order->id;

        $user_id = Auth::id();
        $addressId = $request->address_id;
        $userAddress = UserAddress::where('address_id', $addressId)
            ->where('user_id', $user_id)
            ->first();
        $transporationcost = $this->transporationCost($request);
        $this->cost = $transporationcost->cost;
        $order2 = OrderExternalUser::create(
            [
                'order_id' => $id,
                'user_address_id' => $userAddress->id,
                'trnsporation_costs_id' => $transporationcost->id,
            ]
        );

        return $id;
    }

    public function order2($request)
    {
        DB::beginTransaction();
        $address = Address::find($request->address_id);
        if (!$address) {
            return 'address not found';
        }
        try {
            $id = $this->o($request);
            if ($request->input('products')) {
                $order_detalis =   OrderService::addDetalisToOrder($request, $id);
                if ($order_detalis == 'product not found') {
                    return 'product not found';
                }
            }


            if ($request->input('offers')) {
                OrderOfferServices::storeOrderOffer($request,  $id);
            }
            if ($request->notes) {
                OrderNotes::create([
                    'notes' => $request->notes,
                    'order_id' => $id,
                ]);
            }
            OrderService::calculateTotalPrice($id, $this->cost);
            DB::commit();
            return ResponseService::success('Order placed successfully');
        } catch (Throwable $exception) {
            DB::rollBack();
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function transporationCost($request)
    {
        return $transportationCosts = TransportationCost::where([
            'transport_id' => $request->transport_id,
            'city_id' => $request->city_id,
        ])->first();
    }
}
