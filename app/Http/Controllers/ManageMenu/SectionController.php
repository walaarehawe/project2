<?php

namespace App\Http\Controllers\ManageMenu;
use Throwable;
use Illuminate\Http\Request;
use App\Http\Responses\ResponseService;
use App\Services\ManageMenu\SectionServices;
use App\Http\Controllers\Controller;
use App\Models\Section;
class SectionController extends Controller
{
    
    private SectionServices $Section;
    public function __construct(SectionServices $Section)
    {
      $this->Section = $Section;
    }
  
    
   public function AddSection(Request $request)
   {
       try {
           $data = $this->Section->create($request->all());
           $data1= Section::find($data['data']->id)->first();
           return ResponseService::success($data['message'] , $data1);       
       } catch (Throwable $exception) {
         return ResponseService::error( $exception->getMessage() , 'An error occurred');
       }
   }
   public function EditSection(Request $request)
   {
       try {
        
           $data = $this->Section->update($request['id'] , $request->all());
           
           return ResponseService::success($data['message'] , $data['data']);
           
       } catch (Throwable $exception) {
         return ResponseService::error( $exception->getMessage() , 'An error occurred');
       }
   }

   public function DeleteSection(Request $request)
   {
       try {
           $data = $this->Section->delete($request);
           
           return ResponseService::success($data['message'] , $data['data']);
           
       } catch (Throwable $exception) {
         return ResponseService::error( $exception->getMessage() , 'An error occurred');
       }
   }
   public function ShowSection(Request $request)
   {
       try {
           $data = $this->Section->Show();
           
           return ResponseService::success($data['message'] , $data['data']);
           
       } catch (Throwable $exception) {
         return ResponseService::error( $exception->getMessage() , 'An error occurred');
       }
   }
   public function ChangeStatus(Request $request)
   {
       try {
           $data = $this->Section->ChangeStatus($request);
           
           return ResponseService::success($data['message'] , $data['data']);
           
       } catch (Throwable $exception) {
         return ResponseService::error( $exception->getMessage() , 'An error occurred');
       }
   }
}
