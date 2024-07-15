<?php

namespace App\Services\ManageMenu;

use App\Models\ProductType;
use Illuminate\Http\JsonResponse;
use App\Models\Rating;
use App\Models\Product;
use Laravel\Sanctum\PersonalAccessToken;
use App\Services\CRUDServices;
use Illuminate\Support\Facades\Auth;

class RatingServices extends CRUDServices
{
    public function __construct()
    {
        parent::__construct(new Rating);
    }
    public function AddRating($request)
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());
        $user = $token->tokenable->id;
 
        $rate = Rating::where('product_id', $request['product_id'])->where('user_id', $user)->first();
        if ($rate) {
            $rate->rating = $request['rating'];
            $rate->save();
            $data = $rate;
        } else {
            $request['user_id'] = $user;
            $data = $this->Create($request->all());
        }
        $this->UpdateRating($request);
        return [
            'message' => 'Rating succ',
            'data' => $data
        ];
    }
    public function UpdateRating($request)
    {
        $avg = Rating::where('product_id', $request['product_id'])->avg('rating');
        $data = ProductType::where('id', $request['product_id'])->first();
        $data->total_ratings = $avg;
        $data->save();
        return $data;
    }

}