<?php

namespace App\Services\Reservation;

use App\Models\Reservation\Reservation;
use App\Services\CRUDServices;
use Illuminate\Support\Facades\Hash;
class ReservationServices extends CRUDServices    
{


    public function __construct()
    {
        parent::__construct(new Reservation); 
    }
    // public function AddReservation($request){
     
       
    //       return ['message'=>'login successfully' ,'data'=>, 'status'=>200];
    //   }
  
}