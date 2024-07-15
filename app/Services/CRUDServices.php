<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class CRUDServices    
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function UplodePhoto($request , $FolderName){
        if($request->photo){
            $filename =$request->file('photo')->getClientOriginalName();
            $path =$request->file('photo')->StoreAs($FolderName,$filename,'product');
            $file = $request->file('photo');
            $path ="/images/$FolderName/";
            $file->move($path, $filename);
            }
return $path.$filename;
    }
    public function create($request){
            $data =   $this->model->create($request);
            return ['message' => ' create succ', 'data' =>$data];
    }
    public function delete($id)
    {
        // return $this->model->find($id);
        $this->model->find($id)->delete();
        return ['message' => ' delete succ', 'data' => '  '];
    }
    public function update($id, $data)
    {
        $old = $this->model->find($id);
  
        $old->update($data);
         return ['message' => 'edit succ', 'data' => $old];  
    }
public function show(){
    $data = $this->model->all();
    return ['message' => 'Show succ', 'data' => $data];  
}


}