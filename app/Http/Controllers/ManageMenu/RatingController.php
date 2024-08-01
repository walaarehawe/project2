<?php

namespace App\Http\Controllers\ManageMenu;
use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\Review\Comment;
use App\Services\ManageMenu\CommentServices;
use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Responses\ResponseService;
use App\Services\ManageMenu\RatingServices;
class RatingController extends Controller

{

  private CommentServices $commentServices;
  private RatingServices $ratingServices ;

  public function __construct(RatingServices $ratingServices ,CommentServices $commentServices)
  {
      $this->commentServices = $commentServices;
      $this->ratingServices = $ratingServices;

  }

    // public function __construct(CommentServices $comment)
    // {
    //   $this->$comment =  get_object_vars($comment);
    //   // $this->Rating = $Rating;
    // }


    public function AddRating(Request $request){

      $data = $this->ratingServices->AddRating($request);
      return ResponseService::success($data['message'] , $data['data']);
      
    }     
    
    
    public function AddComment(Request $request){
    $token = PersonalAccessToken::findToken($request->bearerToken());
    $request['user_id']  = $token->tokenable->id;
      $data = $this->commentServices->Create($request->all());
      return ResponseService::success($data['message'] , $data['data']);
    }     

    public function showComment(Request $request){
        $data = $this->commentServices->showComment($request);
        return ResponseService::success("show succ" , $data);
      }     
  

      public function EditComment(Request $request){
         $product = Comment::find($request->id);
        $token = PersonalAccessToken::findToken($request->bearerToken());
        if($product->user_id = $token->tokenable->id){
          $data = $this->commentServices->update($product->id,$request->all());
          return ResponseService::success($data['message'] , $data['data']);
        }   
        return ResponseService::error("not succ","" );

      }

      public function deleteComment(Request $request){
        $data = $this->commentServices->delete($request->id);
        return ResponseService::success($data['message'] , $data['data']);
      }     

    }
