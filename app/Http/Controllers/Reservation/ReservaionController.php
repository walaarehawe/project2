<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Requests\TableReservationRequest;
use App\Http\Responses\ResponseService;
use App\Models\Reservation\TableReservations;
use App\Services\Reservation\ReservationServices;
use Illuminate\Http\Request;
use App\Models\Reservation\Reservation;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;
use App\Models\TableSize;
use App\Models\Table\Table;
use App\Enums\SizeTable;
use Illuminate\Support\Collection;


use Illuminate\Support\Facades\Auth;

class ReservaionController extends Controller
{
    private ReservationServices $reservationServices;
    public function __construct(ReservationServices $reservationServices)
    {
        $this->reservationServices = $reservationServices;

    }
    public function time(Request $request)
    {
    $data = $this->reservationServices->time($request->all());
   
return $data;
}
    public function AddReservation(ReservationRequest $request)
    {

        try {
            // echo 98;
            $token = PersonalAccessToken::findToken($request->bearerToken());
            $user_id=$token->tokenable->id;
            $data = $this->reservationServices->person($request->validated() , $user_id);

            return ResponseService::success($data);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }

    //     public function AddReservation(ReservationRequest $request )
//     {
//     try {
//       $tr=$request->validated();
//       $token = PersonalAccessToken::findToken($request->bearerToken());
//       $tr['user_id']=$token->tokenable->id;
// $data = Reservation::firstOrCreate($tr);
//       return $data['id'];       
//     }
//       catch (Throwable $exception) {
//       return ResponseService::error( $exception->getMessage() , 'An error occurred');
//     }
//     }
    // public function AddTableReservation($id, int $size , int $emptytable)
    // {
    // $rr['reservation_id']= $id;
    // $rr['size_id']=$size;
    // $rr['table_id']=$emptytable;

    // $data =TableReservations::create($rr);
    // return $data;  

    // }









    // public function person(ReservationRequest $request )
    // {
    // $person = $request->persons;
    // $date = $request->Date;
    // $time_id=$request->time_id;
    // $type_id =$request->table_status;
    // $Reservation=Reservation::with('Type')->where('Date',$date)->where('table_status',$type_id)->where('time_id',$time_id)->get(); 
    // $collection2=collect([]);
    // $collection4=collect([]);
    // $collection6=collect([]);
    // foreach($Reservation as $reservation){
    // $type =$reservation->type->all();
    // foreach($type as $types){
    // $size_id=$types->size_id;
    // switch($size_id){
    //   case 1: 
    //     $collection2->push($types);
    //     break;  
    //     case 2: 
    //       $collection4->push($types);
    //       break;  
    //       case 3: 
    //         $collection6->push($types);
    //         break;  
    //     default;  
    //   } }}
    //   if($person <=2){
    // $res =$this->check($type_id ,$collection2->count(),2);
    // if( $res) {
    //   $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //   return $reser;    
    //   } 
    //   $res =$this->check($type_id ,$collection4->count(),4);
    //   if( $res) {
    //     $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //     return $reser;    
    //     } 
    //     $res =$this->check($type_id ,$collection6->count(),6);
    //     if($res) {
    //       $reser =$this->select($request,$res[0] , $collection6 ,$res[1] );
    //       return $reser;    
    //       } 

    //   return "لا يوجد مكان للحجز";
    //   }
    // elseif($person <=4){
    // $res =$this->check($type_id ,$collection4->count(),4);
    //     if( $res) {
    // $reser =$this->select($request,$res[0] , $collection4 ,$res[1] );
    // return $reser;    
    // } 
    // $res =$this->check($type_id ,$collection2->count()+1,2);
    // if($res) {
    //   $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //   $collection2->push($reser);
    //   $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //   return $reser;
    // }
    //   return "فيش طاولة ";
    //     } 

    //     elseif($person <=6){
    //       $res =$this->check($type_id ,$collection6->count(),6);
    //       if( $res) {
    //       $reser =$this->select($request,$res[0] , $collection6 ,$res[1] );
    //       return $reser;    
    //       } 
    //       $res1 =$this->check($type_id ,$collection4->count(),4);
    //       $res2 =$this->check($type_id ,$collection2->count(),2);

    //       if($res1 && $res2) {
    //         $reser =$this->select($request,$res1[0] , $collection4 ,$res1[1] );
    //         $reser =$this->select($request,$res2[0] , $collection2 ,$res2[1] );
    //         return $reser;
    //       }
    //       $res =$this->check($type_id ,$collection2->count()+2,2);
    //       if($res) {
    //         $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //         $collection2->push($reser);
    //         $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //         $collection2->push($reser);
    //         $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //         return $reser;
    //       }
    //       $res =$this->check($type_id ,$collection4->count()+1,4);
    //       if($res) {
    //         $reser =$this->select($request,$res[0] , $collection4 ,$res[1] );
    //         $collection4->push($reser);
    //         $reser =$this->select($request,$res[0] , $collection4 ,$res[1] );
    //         return $reser;
    //       }}       
    //       elseif($person <=8){
    //         $res =$this->check($type_id ,$collection4->count()+1,4);
    //         if($res) {
    //           $reser =$this->select($request,$res[0] , $collection4 ,$res[1] );
    //           $collection4->push($reser);
    //           $reser =$this->select($request,$res[0] , $collection4 ,$res[1] );
    //           return $reser;
    //         }
    //         $res1 =$this->check($type_id ,$collection6->count(),6);
    //         $res2 =$this->check($type_id ,$collection2->count(),2);

    //         if($res1 && $res2) {
    //           $reser =$this->select($request,$res1[0] , $collection6 ,$res1[1] );
    //           $reser =$this->select($request,$res2[0] , $collection2 ,$res2[1] );
    //           return $reser;
    //         }
    //         $res =$this->check($type_id ,$collection2->count()+3,2);
    //         if($res) {
    //           $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //           $collection2->push($reser);
    //           $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //           $collection2->push($reser);
    //           $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
    //           return $reser;
    //         }
    //         return "فيش طاولة ";
    //           } 
    // }



    // public function check( $type_id , $collection , $size_id)
    // {
    // $table = collect([]);
    // $TableSize = TableSize::where('type' , $type_id)->where('size', $size_id)->first();
    // $count6 =$TableSize->count;
    // $tables = Table::where('type_id' , $type_id)->where('size_id', $TableSize->id)->get();
    // foreach($tables as $tt){
    // $table->push($tt['id']);
    // }    
    // echo $count6;
    // echo $collection;

    // if ( $count6 > $collection ) 
    // return [$table ,$TableSize->id] ;
    // return [];
    // }


    // public function select(ReservationRequest $request ,$table, $collection , $size_id)
    // {
    // foreach(  $collection as $types){
    // $table_id=$types->table_id;
    // if($table_id){
    // if ($table->contains($table_id)){
    // $table = $table->reject(function ($value ) use ($table_id) {
    //   return $value === $table_id;
    // });
    // }
    // }
    // }
    // if(!$table->isEmpty()){
    // $emptytable = $table->first();
    // $ro= $this->AddReservation($request  );
    // $rr= $this->AddTableReservation($ro ,$size_id ,$emptytable);
    // return $rr ;
    // }
    // return null;
    //  }
}











