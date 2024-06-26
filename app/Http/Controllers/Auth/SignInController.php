<?php

namespace App\Http\Controllers\Auth;
use App\Http\Requests\SignInRequest ;
use App\Http\Responses\ResponseService;
use Throwable;
use App\Services\Auth\LoginServices ;
use App\Http\Controllers\Controller;
class SignInController extends Controller
{

  private LoginServices  $signin;
  public function __construct(LoginServices $signin)
  {
    $this->signin  = $signin;
  }

  public function login(SignInRequest $request)
  {
    try {
     $data = $this->signin->login($request->validated());
      if( $data['status']==200 )
      return ResponseService::success($data['message'] , $data['data']);
      else
      return ResponseService::error($data['message'] , $data['data']);
  } 
  catch (Throwable $exception) {
    return ResponseService::error( $exception->getMessage() , 'An error occurred');
  }
}













}
