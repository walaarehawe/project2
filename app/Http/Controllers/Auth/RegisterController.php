<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Http\Request;
use App\Http\Responses\ResponseService;
use App\Services\Auth\SignUpServices;
use App\Http\Controllers\Controller;
use Throwable;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class RegisterController extends Controller
{

  private SignUpServices $signUpServices;
  public function __construct(SignUpServices $signUpServices)
  {
    $this->signUpServices = $signUpServices;
  }

  public function register(SignUpRequest $request)
  {

    try {
      $data = $this->signUpServices->register($request->validated());
      
      return ResponseService::success($data['message'] , $data['data']);
      
  } catch (Throwable $exception) {
    return ResponseService::error( $exception->getMessage() , 'An error occurred');
  }

}

public function code(Request $request){
  $data = [];
  $rr['name']=$request->name;
  $rr['phone']=$request->phone;
  $rr['password']=$request->password;
  if($request->phone){
    $data = $this->signUpServices->codegenegation($request->phone);
    return ResponseService::success($rr , $data['data']);
  }

  return ResponseService::error('number isnot exist', ' ');
}


public function codeforfpass (Request $request){
  $data = [];
  // $rr['name']=$request->name;
  $rr['phone']=$request->phone;
  // $rr['password']=$request->password;
  if($request->phone){
    $data = $this->signUpServices->codegenegation($request->phone);
    return ResponseService::success($rr , $data['data']);
  }

  return ResponseService::error('number isnot exist', ' ');
}

public function forgetpassword (Request $request){
  $user = User::where('phone' , $request->phone)->first();
$user->password = Hash::make($request['password']);
$user->save();
return $user;

}










}
