<?php

namespace App\Services\ManageMenu;

use Illuminate\Http\JsonResponse;
use App\Models\Review\Comment;
use App\Models\Product;
use Laravel\Sanctum\PersonalAccessToken;
use App\Services\CRUDServices;
use Illuminate\Support\Facades\Auth;

class CommentServices extends CRUDServices
{
    public function __construct()
    {
        parent::__construct(new Comment);
    }
    public function showComment( $request){

$data =Comment::with('user')->where('product_id',$request->product_id)->get();
return $data;
      }  
}