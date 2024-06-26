<?php

namespace App\Http\Controllers\Address;

//use App\Models\Address\Address;
use App\Models\Transport;
use App\Models\TransportationCost;
use App\Services\Address\AddressServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\Address\Address;
use App\Models\Address\UserAddress;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Throwable;
class AddressController extends Controller
{
    
  private AddressServices $addressServices;
  public function __construct(AddressServices $addressServices)
  {
    $this->addressServices => $addressServices;
  }

       public function store(Request $request)
    {
        try {
            $data = $this->addressServices->store($request);
            
            return ResponseService::success($data['message'] , $data['data']);
            
        } catch (Throwable $exception) {
          return ResponseService::error( $exception->getMessage() , 'An error occurred');
        }}
   
    public function show(Request $request)
    {
        $user_id = Auth::id();
        $user = UserAddress::where('user_id',$user_id)->get();  
        foreach ($user as $address) {
       $address_id[] = $this->showuseraddress($address->address_id);
        }
        return  $address_id ;
    }
    public function showuseraddress( $id)
    {
        $child = Address::find($id);

        if ($child) {
            $ancestors = $child->getAncestors();
            $i=1;
           
            while($ancestors !=null){
                $mm[$i]=$ancestors['name'];
                $ll[$i]=$ancestors['id'];
           $i++;
           if(!$ancestors['parent']){
            break;}
           $ancestors=$ancestors['parent'];
    $countryid = $ancestors['id'];
            }
for($i ;$i<=5 ;$i++){
    $mm[$i] = null;
}
$mm['countryid']=$countryid;
$mm['lastid']=$id;
return $mm;

    }
}
    public function AddTransportationCost(Request $request){  

$cost =TransportationCost::create([
'transport_id'=>$request->transport_id,
'city_id'=>$request->city_id,
'cost'=>$request->cost,
]);

return ResponseService::success('Transportation Cost Add Successfuly', $cost);
// return $cost;
        }
        
    public function Addtransport(Request $request){  
   
$cost =Transport::create([
'transport'=>$request->transport,
]);
// return $cost;
return ResponseService::success('Transport Add Successfuly', $cost);
        }

        public function showtransport(){ 
        $transport =Transport::get();
        return ResponseService::success('Transport show Successfuly', $transport);
        // return  $transport;
        }



        public function Selecttransport(Request $request){ 
$cost =TransportationCost::where('transport_id',$request->transport_id)->where('city_id',$request->city_id)->first();
// return $cost->cost; 
return ResponseService::success(' Successfuly', $cost->cost);

        }
}