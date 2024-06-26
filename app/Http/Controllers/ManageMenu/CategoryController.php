<?php

namespace App\Http\Controllers\ManageMenu;
use Throwable;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Http\Responses\ResponseService;
use App\Services\ManageMenu\CategoryServices;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private CategoryServices $Category;
    public function __construct(CategoryServices $Category)
    {
      $this->Category = $Category;
    }
    public function AddCategory(Request $request)
    {
        try {
          $path=  $this->Category->UplodePhoto($request , 'category');
          $newrequest = $request->all();
          unset($newrequest['photo']);
          $newrequest['category_path']=$path;
            $data = $this->Category->create($newrequest);
            return ResponseService::success($data['message'] , $data['data']);       
        } catch (Throwable $exception) {
          return ResponseService::error( $exception->getMessage() , 'An error occurred');
        }
    }
    public function EditCategory(Request $request)
    {
        try {
         
            $data = $this->Category->update($request['id'] , $request->all());
            
            return ResponseService::success($data['message'] , $data['data']);
            
        } catch (Throwable $exception) {
          return ResponseService::error( $exception->getMessage() , 'An error occurred');
        }
    }
 
    public function DeleteCategory(Request $request)
    {
        try {
            $data = $this->Category->delete($request);
            
            return ResponseService::success($data['message'] , $data['data']);
            
        } catch (Throwable $exception) {
          return ResponseService::error( $exception->getMessage() , 'An error occurred');
        }
    }
    public function ShowCategory(Request $request)
    {
        try {
            $data = $this->Category->ShowCategory();
            return ResponseService::success($data['message'] , $data['data']);
            
        } catch (Throwable $exception) {
          return ResponseService::error( $exception->getMessage() , 'An error occurred');
        }
    }
  
}
