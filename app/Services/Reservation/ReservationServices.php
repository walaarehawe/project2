<?php

namespace App\Services\Reservation;
use App\Models\Reservation\Reservation;
use App\Models\Reservation\TableReservations;
use App\Models\Time;
use Illuminate\Http\JsonResponse;
use App\Models\TableSize;
use App\Models\Table\Table;
use Illuminate\Support\Facades\Auth;

use App\Models\Section;
use App\Services\CRUDServices;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Throwable;

class ReservationServices extends CRUDServices
{
  
  public function __construct()
  {
      parent::__construct(new Reservation()); 
  }
 public $person ;
 public $date  ;
 public $time_id;
 public $type_id ;

public  $size_id;
public $collection2;
public $collection4;
public $collection6;

// public function DeleteReservation($request){
//    $data = Reservation::find($request->id);
//    $data->delete();
//   }
public function ShowuserReservation($user_id){
  return   $data = Reservation::with('time')->with('Type')->where('user_id',$user_id)->orderBy('Date', 'asc')->orderBy('time_id', 'asc')->get();
  }
public function ShowallReservation(){
return   $data = Reservation::with('time')->with('user')->with('Type')->orderBy('Date', 'asc')->orderBy('time_id', 'asc')->get();
}
 public  function time( $request ){
  $alltimes = Time::where('avilable',0)->get();
  // return $times;
   $this->person = $request['persons'];
    $this->date = $request['Date'];
    $this->type_id =$request['table_status'];
    $Reservation=Reservation::with('Type')->where('Date',$this->date)->where('table_status',$this->type_id)->get(); 
    // return  $Reservation;
    $times=collect([]);
    foreach($alltimes as $time){
      $times->push($time);

    }
    $this->collection2=collect([]);
    $this->collection4=collect([]);
    $this->collection6=collect([]);
    foreach($times as $time){
    foreach($Reservation as $reservation){
    if($reservation->time_id == $time->id){
// echo $time;
      $type =$reservation->type->all();
      foreach($type as $types){
     $this->size_id=$types->size_id;
    switch($this->size_id){
      case 4 : 
        case 1 : 
        $this->collection2->push($types);
        break;  
        case  5: 
          case 2 : 
            $this->collection4->push($types);
          break;  
          case 6: 
          case 3 :
            $this->collection6->push($types);
            break;  
        default;  
      }
    
    
    $times= $this->timeforperson( $times ,$time );
       
    }}  } } 
    return $times;
 }


 public function timeforperson( $times ,$time )
    {

      if($this->person <=2){ 
        $data1= $this->CheckTime(  $this->collection2 ,$times ,$time,1 );
   
    $data2= $this->CheckTime( $this->collection4 ,$times ,$time ,1 );
    
        $data3= $this->CheckTime( $this->collection6,$times ,$time ,1 );
        if(!$data1 && !$data2 && !$data3){
          $times = $times->reject(function ($value)use ($time) {
            return $value === $time;
          });        
          
        }
        return    $times; 
                }
        elseif($this->person <=4){
          $data1= $this->CheckTime( $this->collection4 ,$times ,$time ,1);
         
        $data2= $this->CheckTime(  $this->collection2 ,$times ,$time,2);
         
          $data3= $this->CheckTime( $this->collection6 ,$times ,$time,1 );
          if(!$data1 && !$data2 && !$data3){
            $times = $times->reject(function ($value)use ($time) {
              return $value === $time;
            });        
          }
          return    $times;   
    }         
    
            elseif($this->person <=6){
              $data1= $this->CheckTime($this->collection6 ,$times ,$time,1 );
            
              $result1=  $this->CheckTime( $this->collection4 ,$times ,$time ,1);
              $result2=  $this->CheckTime(  $this->collection2 ,$times ,$time ,1);
              $result = true;       

              if (!$result2 || !$result1){
                $result = false;
                       
              }
              $data2=  $this->CheckTime(  $this->collection2 ,$times ,$time ,3);
              
              $data3=  $this->CheckTime( $this->collection4 ,$times ,$time ,2);
            
              if(!$data1 && !$data2 && !$data3 && !$result){
                $times = $times->reject(function ($value)use ($time) {
                  return $value === $time;
                });        
              }
              return    $times;   
            }             
              elseif($this->person <=8){
                $data=  $this->CheckTime( $this->collection4 ,$times ,$time ,2);


                $res1 =  $this->CheckTime( $this->collection6 ,$times ,$time ,1);
                $res2 =  $this->CheckTime(  $this->collection2 ,$times ,$time ,1);
                $result = true;       
                if (!$res2 || !$res1){
                  $result = false;        
                }

                $data2=  $this->CheckTime(  $this->collection2 ,$times ,$time ,3);
                if( !$data2 && !$result){
                  $times = $times->reject(function ($value)use ($time) {
                    return $value === $time;
                  });        
                }
                return    $times; 
                  } 
        }


    

    public function CheckTime( $collection ,$times ,$time ,$num)
    {
      $TableSize =TableSize::where('type' , $this->type_id)->where('id', $this->size_id)->first();
      $count6 =$TableSize->count;      
      if ( $count6 <= $collection->count()+$num-1 ){
      return false; 
      }

      return true;
  
    } 
    public function Reservationtable( $request , $tables )
    {
            $request['user_id'] =1;
            $request['table_status'] =Table::find($tables[0])->type_id;
$data = $this->AddReservation($request);
foreach($tables as $table){
  $size = Table::find($table)->size_id;
  $data1 = $this->AddTableReservation($data , $size , $table);
}
return $data1;

    }
    public function AddReservation( $request )
    {
      $data = Reservation::Create($request);
      return $data['id'];       
 
    }
    public function AddTableReservation($id, int $size , int $emptytable)
    {
    $rr['reservation_id']= $id;
    $rr['size_id']=$size;
    $rr['table_id']=$emptytable;

     $data =TableReservations::create($rr);
    return $data;  
    }
    public  function select($request ,$table, $collection , $size_id)
    {
    foreach($collection as $types){
    $table_id=$types->table_id;
    if($table_id){
    if ($table->contains($table_id)){
    $table = $table->reject(function ($value ) use ($table_id) {
      return $value === $table_id;
    });}}}
    if(!$table->isEmpty()){
    $emptytable = $table->first();
    // echo" ro";

    $ro=$this->AddReservation($request);
    // echo" ro";
    // echo $ro;
    $rr=$this->AddTableReservation($ro ,$size_id ,$emptytable);
    return $rr ;
    }
    return null;
            }
public function two($request ,$collection2 , $num){
  $res =$this->check($collection2->count()+$num-1,2);
  if($res) {
  for($i = 0 ; $i<$num ;){
  echo $i;
      $reser =$this->select($request,$res[0] , $collection2 ,$res[1] );
      $collection2->push($reser);
      $i=$i+1;   
    }
    return $reser;
  } 
  return null;
}
public function four($request  ,$collection4 , $num){
  $res =$this->check($collection4->count()+$num-1,4);
  if($res) {
  for($i = 0 ; $i<$num ;){
  echo $i;
      $reser =$this->select($request,$res[0] , $collection4 ,$res[1] );
      $collection4->push($reser);
      $i=$i+1;   
    }
    return $reser;
  } 
  
  return null;
}
public function six($request  ,$collection6,$num){
  $res =$this->check($collection6->count()+$num-1,6);
  if($res) {
  for($i = 0 ; $i<$num ;){
  echo $i;
      $reser =$this->select($request,$res[0] , $collection6 ,$res[1] );
      $collection6->push($reser);
      $i=$i+1;   
    }
    return $reser;
  } 
  return null;
}
    public function check(  $collection , $size_id)
    {
    $table = collect([]);
    $TableSize =TableSize::where('type' , $this->type_id)->where('size', $size_id)->first();
    $count6 =$TableSize->count;
    $tables = Table::where('type_id', $this->type_id)->where('size_id', $TableSize->id)->get();
    foreach($tables as $tt){
    $table->push($tt['id']);
    }    
    if ( $count6 > $collection ) 
    return [$table ,$TableSize->id] ;
    return [];
    }

    public function ShowTable($request)
    
    {
      $this->date = $request['Date'];
      $this->time_id=$request['time_id'];
      $Reservation=Reservation::with('Type')->where('Date',$this->date)->where('time_id',$this->time_id)->get(); 
    $tables = Table::with('size')->get();    
      foreach($Reservation as $reservation){
        $type =$reservation->type->all();
        foreach($type as $types){
          $table_id= $types->table_id;
          foreach($tables as $tt){
            if ($table_id==$tt->id){
              $tables = $tables->reject(function ($value ) use ($tt) {
                return $value === $tt;
            });
              }
            }   
          }
      }
      return $tables;
      }

    public function person($request , $user_id)
    
    {

      $request['user_id']=$user_id;
    $this->person = $request['persons'];
    $this->date = $request['Date'];
    $this->time_id=$request['time_id'];
    $this->type_id =$request['table_status'];
    $Reservation=Reservation::with('Type')->where('Date',$this->date)->where('table_status',$this->type_id)->where('time_id',$this->time_id)->get(); 
    $collection2=collect([]);
    $collection4=collect([]);
    $collection6=collect([]);
    foreach($Reservation as $reservation){
    $type =$reservation->type->all();
    foreach($type as $types){
    $size_id=$types->size_id;
    switch($size_id){
      case 4 : 
        case 1 : 
        $collection2->push($types);
        break;  
        case  5: 
          case 2 : 
          $collection4->push($types);
          break;  
          case 6: 
          case 3 :
            $collection6->push($types);
            break;  
        default;  
      } }}
      if($this->person <=2){ 
        
    $data =$this->two($request ,$collection2 , 1);
if($data){
     return ['message' => ' succ', 'data' =>$data];

}
    $data =$this->four($request ,$collection4 , 1);
    if($data){
         return ['message' => ' succ', 'data' =>$data];
    
    }
        $data =$this->six($request ,$collection6 , 1);
        if($data){
             return ['message' => ' succ', 'data' =>$data];
        }
      return "لا يوجد مكان للحجز";
      }
    elseif($this->person <=4){
      
    $data =$this->four($request ,$collection4 , 1);
    if($data){
         return ['message' => ' succ', 'data' =>$data];
    }
      $data =$this->two($request ,$collection2 , 2);
      if($data){
           return ['message' => ' succ', 'data' =>$data];
      }
    $data =$this->six($request ,$collection6 , 1);
    if($data){
         return ['message' => ' succ', 'data' =>$data];
    }
      return "فيش طاولة ";
}         

        elseif($this->person <=6){
          
          $data =$this->six($request ,$collection6 , 1);
          if($data){
  return ['message' => ' succ', 'data' =>$data];
          }
          $res1 =$this->check($collection4->count(),4);
          $res2 =$this->check($collection2->count(),2);

          if($res1 && $res2) {
            $reser =$this->select($request,$res1[0] , $collection4 ,$res1[1] );
            $reser =$this->select($request,$res2[0] , $collection2 ,$res2[1] );
  return ['message' => ' succ', 'data' =>$reser];
          }
          $data =$this->two($request ,$collection2 , 3);
          if($data){
  return ['message' => ' succ', 'data' =>$data];
          }
                    $data =$this->four($request ,$collection4 , 2);
          if($data){
  return ['message' => ' succ', 'data' =>$data];
                    }}
          elseif($this->person<=8){
            // echo 1;

            $data =$this->four($request ,$collection4 , 2);
            if($data){
    return ['message' => ' succ', 'data' =>$data];
            }
            $res1 =$this->check($collection6->count(),6);
            $res2 =$this->check($collection2->count(),2);
            if($res1 && $res2) {
              $reser =$this->select($request,$res1[0] , $collection6 ,$res1[1] );
              $reser =$this->select($request,$res2[0] , $collection2 ,$res2[1] );
    return ['message' => ' succ', 'data' =>$reser];
            }
            $data =$this->two($request ,$collection2 , 3);
            if($data){
   return ['message' => ' succ', 'data' =>$data];
            
            }
            return "فيش طاولة ";
              } 
    }}

