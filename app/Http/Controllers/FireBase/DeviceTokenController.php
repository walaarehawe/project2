<?php

namespace App\Http\Controllers\FireBase;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceTokenController extends Controller
{
    public function store(Request $request){

        $user= Auth::user();
      $exist=$user->deviceTokens
      ->where('device_token','=',$request->device_token)->first();
      ;
      if(!$exist){
         DeviceToken::create([
             'device_token'=>$request->device_token,
             'user_id'=>$user->id,
             
                     ]);
                     return 'you add device token succsesfuly';
      }
      else{
         return 'device token exists already';
      }
    }
}
