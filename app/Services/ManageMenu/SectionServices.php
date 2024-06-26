<?php

namespace App\Services\ManageMenu;
use Illuminate\Http\JsonResponse;

use App\Models\Section;
use App\Services\CRUDServices;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SectionServices extends CRUDServices
{
    public function __construct()
    {
        parent::__construct(new Section()); 
    }

    public function ChangeStatus($request)
    {
        $section = Section::where('id', $request['id'])->first();
        if ($section['status']) {
            $section['status'] = false;
        }
        else {
            $section['status'] = true;
        }
        $section->save();
        return ['message' => 'status changed succ', 'data' => $section];
    }




}