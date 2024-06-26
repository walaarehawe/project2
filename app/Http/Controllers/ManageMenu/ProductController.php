<?php

namespace App\Http\Controllers\ManageMenu;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductTypeRequest;
use Illuminate\Http\Request;
use App\Http\Responses\ResponseService;
use App\Services\ManageMenu\ProductServices;
use App\Models\ProductType;
use Throwable;
use App\Http\Controllers\Controller;
class ProductController extends Controller
{
    private ProductServices $productServices ;
    public function __construct(ProductServices $productServices)
    {
      $this->productServices = $productServices;
    }

    public function Search(Request $request){
      return ProductType::where('name','LIKE','%'.$request->name.'%')
                      ->get();
      
      // return [
      // 'message' => 'show succ',
      // 'data' => $data];
  }

    public function Addproduct(Request $request)
    {

        try {

          $path=  $this->productServices->UplodePhoto($request , 'products');
        
          $data = $this->productServices->Addproducts($request,$path);
          // return $request;
            return ResponseService::success($data['message'] , $data['data']);
            
        } catch (Throwable $exception) {
          return ResponseService::error( $exception->getMessage() , 'An error occurred');
        }
   }
   public function Editproduct(ProductRequest $request , ProductTypeRequest $requests )
   {
   
       try{
        $path=  $this->productServices->UplodePhoto($request , 'products');
        $data1 =$this->productServices->updateproducts($requests->id, $requests->validated());
        $data =$this->productServices->updateproduct($data1['message'], $request->validated(), $path);
     
        return ResponseService::success($data['data'] , $data1['data']);
       }
        catch (Throwable $exception) {
        return ResponseService::error( $exception->getMessage() , 'An error occurred');
       }
  }


    public function DeleteProduct(Request $request){
      $data =$this->productServices->delete( $request);
      return ResponseService::success($data['message'] , $data['data']);
    }

    public function Showproduct(Request $request){
      $data =$this->productServices->showproduct();
      return ResponseService::success($data['message'] , $data['data']);
    }


public function Filter(Request $request){
  $data = $this->productServices->Filter($request);
  return ResponseService::success($data['message'] ,$data['data']); 
}


public function AddProductType(Request $request){
  $data = ProductType::create($request->all());
  return ResponseService::success('da' , $data);  
}
// public function ChangeType(Request $request){
// $data = $this->productServices->ChangeType($request);

// return ResponseService::success($data['message'] , $data['data']);

// }

// public function ShowType(Request $request){
// $data = $this->productServices->ShowType($request);

// return ResponseService::success($data['message'] , $data['data']);

// }


public function showDetails(Request $request ){
  $data = $this->productServices->showDetails($request);

return ResponseService::success($data['message'] , $data['data']);

}


  }
