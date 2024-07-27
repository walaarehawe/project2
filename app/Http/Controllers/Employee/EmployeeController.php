<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Models\Employee;
use App\Models\Employee_transport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Services\ManageMenu\ProductServices;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
     private ProductServices $productServices ;
     public function __construct(ProductServices $productServices)
     {
       $this->productServices = $productServices;
     }
 
    public function AddEmployee(Request $request)
   {
     $path=  $this->productServices->UplodePhoto($request , 'products');
        
     // $data = $this->productServices->Addproducts($request,$path);
        $user = User::Create([
          'phone'=>$request->phone,
          'password'=>Hash::make($request['password']),
          'name'=>$request->name,
     ]);
        $requests['user_id']=$user['id'];
        $requests['cv_path']=$path;
        $requests['active']=1;
        $role_type=Role::query()->where('name','customer')->first();
        setPermissionsTeamId(1);
        $user->assignRole($role_type);
        $permissions = $role_type->permissions()->pluck('name')->toArray();
        $user ->givePermissionTo($permissions);
        $user->load('roles','permissions'); //to recognize the permissions
        $employee = Employee::Create($requests);
        if($request->Role == "customer"){
          $this->AddTranspot($employee->id,$request->transport_id);
        }
return $employee ;

   }
     public function AddTranspot( $id , $transport){
          Employee_transport::Create([
               'employee_id'=>$id,
               'transport_id'=>$transport
          ]);

}
public function EditEmployee(Request $request)
{
  $path=  $this->productServices->UplodePhoto($request , 'products');
  $user = User::find($request->id);
$data['name']=$request->name;
$data['phone']=$request->phone;
$data['password']=Hash::make($request['password']);

$user->update($data);
if($request->transport_id){

     $employee = Employee::where('user_id',$user->id)->first();

      $employees = Employee_transport::where('employee_id',$employee->id)->first();

         $employees->transport_id=$request->transport_id;
          $employees->save();
}

return $user ;

}   
public function DeleteEmployee(Request $request)
{

  $user = User::find($request->id);
$user->delete();
return "delete succ";
}
public function ShowEmployee(Request $request)
{

 return $user = User::with('Employee')->get();

}
public function ShowEmployeeDetails(Request $request)
{
 return $user = User::with('Employee')->find($request->id);
}

public function ChangeActivity(Request $request)
{
 $id =Auth::id();
  $user = Employee::where('user_id',$id)->first();
 $user->active = !$user->active;
 $user->save();
return $user;
}
public function ChangeEmployeeActivity( Request $id)
{
  $user = Employee::find($id)->first();
 $user->active = !$user->active;
 $user->save();
return $user;
}




}
