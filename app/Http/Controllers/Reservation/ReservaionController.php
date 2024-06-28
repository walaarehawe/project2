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
    public function AddReservation(ReservationRequest $request , int $size)
    {
        try {
          $tr=$request->validated();
          $token = PersonalAccessToken::findToken($request->bearerToken());
          $tr['user_id']=$token->tokenable->id;

          $data = $this->reservationServices->create($tr);
        
        //  $rr=$re->validated();
         $rr['reservation_id']= $data['data']['id'];
         $rr['size_id']=$size;
         $data =TableReservations::create($rr);
          return ResponseService::success($data);       
        }
         catch (Throwable $exception) {
          return ResponseService::error( $exception->getMessage() , 'An error occurred');
        }
    }












    public function select(ReservationRequest $request )
    {
      $person = $request->persons;
      $date = $request->Date;

      if($person>=7)
{
  $Reservation=Reservation::with('Type')->where('Date',$date)->get(); 
// return  $Reservation;
  $collection = collect([]);
  foreach($Reservation as $reservation){
    $type =$reservation->type->all();
    foreach($type as $types){
    $size_id=$types->size_id;
    if($size_id &&$size_id==2){
      $collection->push($types);
    }

  }
    }
    // $requests ['size_id']=6;
    echo 1;
  //  $rt =TableReservationRequest::validated( $requests);
  //  echo 2;
  // return $requests;
//    $requests = new TableReservationRequest; // Create an instance of the request class
// $rt = $requests->validated($requests->all());

   $count6 = SizeTable::six;
  if($collection->count()<$count6){
    $size=1;
$rr= $this->AddReservation($request ,$size);
return $rr ;
  }







  // return  $collection->count();
  // print_r($collection);
  // return $t6;

  // $r=$t6->where('size_id',1)->all(); 
// echo $t6;
}

// return $ty->size_id;
    }










}
