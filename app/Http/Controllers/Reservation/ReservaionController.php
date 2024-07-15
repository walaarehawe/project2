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
use App\Models\Time;
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
    public function ShowTable(Request $request)
    {
        $data = $this->reservationServices->ShowTable($request->all());

        return $data;
    }

    public function ShowTime(Request $request)
    {
        $data = Time::where('avilable',0)->get();

        return $data;
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
            $user_id = $token->tokenable->id;
            $data = $this->reservationServices->person($request->validated(), $user_id);

            return ResponseService::success($data);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function AddTableReservation(TableReservationRequest $request)
    {

        try {

// $res = Reservation::where('Date',$request->Date &&'time_id',$request->time_id &&'person',$request->person)->first();
// if(!$res){
//     return $res;
// }

            $table_id =$request->table_id;
                        // $request['tabe_status'] =Table::find($tables[0])->type_id;
// retuen $table_id;
            $data = $this->reservationServices->Reservationtable($request->validated() ,$table_id );
           return ResponseService::success("add succ",$data);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }

    public function ShowallReservation()
    {

        try {
            // $table_id =$request->table_id;
            $data = $this->reservationServices->ShowallReservation();
           return ResponseService::success($data);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function ShowuserReservation(Request $request)
    {

        try {
            $token = PersonalAccessToken::findToken($request->bearerToken());
            $user_id = $token->tokenable->id;         
               $data = $this->reservationServices->ShowuserReservation($user_id);
           return ResponseService::success($data);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function DeleteReservation(Request $request)
    {

        try {         
               $data = $this->reservationServices->delete($request->id);
           return ResponseService::success($data);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}











