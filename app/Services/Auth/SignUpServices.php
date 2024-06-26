<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class SignUpServices
{

    public function register($request){
     $request['role']='customer';
        $user = User::create([ 
          'name'=>$request['name'],
          'phone'=>$request['phone'],
          'password'=>Hash::make($request['password']),
        ]);
      
        $role_type=Role::query()->where('name','customer')->first();
        setPermissionsTeamId(1);
        $user->assignRole($role_type);
        $permissions = $role_type->permissions()->pluck('name')->toArray();
        $user ->givePermissionTo($permissions);
        $user->load('roles','permissions'); //to recognize the permissions
        $token = $user->createToken('token')->plainTextToken;
        return ['message'=>'user create succ' , 'data'=>$token];
    }


    public function codegenegation($request){
      $code =1234;
      $phone = $request;
      $params=array(
      'token' => 'we4isu0z6vm684xl',
      'to' => $phone,
      'body' =>  $code
      );
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.ultramsg.com/instance82094/messages/chat",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_HTTPHEADER => array(
          "content-type: application/x-www-form-urlencoded"
        ),
      ));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);
      if ($err) {
        echo "cURL Error #:" . $err;
      } else {
        return ['message'=>$request, 'data'=>$code];   
      }
    }

    public function login($request){
      $user =User::where('phone',$request['phone'])->first();
      if(!$user||!Hash::check($request['password'],$user->password)){
        return ['message'=>'bad creds' , 'data'=>'  ', 'status'=>400];
      }
         $token = $user->createToken('usertoken')->plainTextToken;
        return ['message'=>'login successfully' ,'data'=>$token, 'status'=>200];
    }

  }

