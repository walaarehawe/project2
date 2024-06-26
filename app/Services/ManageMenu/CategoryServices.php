<?php

namespace App\Services\ManageMenu;
use App\Models\Category;
use App\Services\CRUDServices;
class CategoryServices  extends CRUDServices
{

    public function __construct()
    {
        parent::__construct(new Category); 
    }
    

    public function ShowCategory(){
        $data = Category::with('section')->get();
    return ['message' => 'show succ',
    'data' => $data];
    }

}