<?php

namespace App\Services\Address;
use App\Models\Transport;
use App\Models\TransportationCost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Responses\ResponseService;
use App\Models\Address\Address;
use App\Models\Address\UserAddress;
use Illuminate\Support\Facades\Auth;


class AddressServices  
{
    public function store( $request)
    {
        $Address[0] = $request->city;
        $Address[1] = $request->street;
        $Address[2] = $request->building;
        $Address[3] = $request->floor;
        $Address[4] = $request->details;
        $ParentId = null;
        foreach ($Address as $address) {
            if ($address) {
                $parent = Address::where('name', $address)->where('parent_id', $ParentId)->first();
                if ($parent == null) {
                    $parent = Address::create([
                        'name' => $address,
                        'parent_id' => $ParentId
                    ]);
                }
                $ParentId = $parent->id;
                $result[] = $ParentId;
            }}
        $d = UserAddress::create([
            'user_id' => Auth::id(),
            'address_id' => $ParentId,
        ]);
        return['message'=>'Address Add Successfuly','data'=> $d];
    }
   
    public function show($request)
    {
        
        $user_id = Auth::id();
        $user = UserAddress::where('user_id',$user_id)->get();  
        foreach ($user as $address) {
            // $address_id[]=$this->showuseraddress($address->address_id);
        }

        // return  $address_id ;

    }


    public static function showuseraddress( $request)
    {
        // $user_id = Auth::id();
        // $user = User::find($user_id);
        // foreach ($user->address as $add) {
        //     $address_id[] = $add->address_id;
        // }
        // $child = Address::find($address_id);
        // if ($child) {
        //     foreach ($child as $childf) {
        //         $ancestors[] = $childf->getAncestors();
        //     }
        // }
           
        // return response()->json([
        //     'ancestors' => $ancestors
        // ]);
 
 
 
 
 
 
 
 
//         // $child = Address::find($request->id);

//         // if ($child) {
//             $ancestors = $child->getAncestors();
//             $i=1;
           
//             while($ancestors !=null){
//                 $mm[$i]=$ancestors['name'];
//                 $ll[$i]=$ancestors['id'];
//            $i++;
//            if(!$ancestors['parent']){
//             break;}
//            $ancestors=$ancestors['parent'];
//     $countryid = $ancestors['id'];

//             }
// for($i ;$i<=5 ;$i++){
//     $mm[$i] = null;
// }
//             return response()->json (
//                ['data'=>  $mm , 'countryid'=>$countryid, 'lastid'=>$request->id]);
         
 
//     }
}
}