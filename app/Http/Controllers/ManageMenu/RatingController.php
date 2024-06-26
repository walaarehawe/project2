<?php

namespace App\Http\Controllers\ManageMenu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; 

use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Responses\ResponseService;
use App\Services\ManageMenu\RatingServices;
class RatingController extends Controller
{
    private RatingServices $Rating ;
    public function __construct(RatingServices $Rating)
    {
      $this->Rating = $Rating;
    }
    public function AddRating(Request $request){

      $data = $this->Rating->AddRating($request);
      return ResponseService::success($data['message'] , $data['data']);
      
    }      
}
