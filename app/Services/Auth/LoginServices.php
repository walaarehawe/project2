<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
class LoginServices    
{


    public function login($request){
     
        $user =User::where('phone',$request['phone'])->first();
        if(!$user||!Hash::check($request['password'],$user->password)){
          return ['message'=>'bad creds' , 'data'=>'  ', 'status'=>400];
        
        }
           $token = $user->createToken('usertoken')->plainTextToken;
           
          return ['message'=>'login successfully' ,'data'=>$token, 'status'=>200];
      }
  
}