<?php

namespace App\Services\Table;

use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\Table\Table;
use App\Services\CRUDServices;

class TableService extends CRUDServices
{
    public function __construct()
    {
        parent::__construct(new Table());
    }

    public function store($request)
    {
        $type_table = $request->type_table;
        $number=$request->number;
        try {
            for ($i = 0; $i < $number; $i++) {
                $table =  $this->create(['type_id' => $type_table]);
            }
            return "success";
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
