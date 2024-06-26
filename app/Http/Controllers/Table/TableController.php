<?php

namespace App\Http\Controllers\Table;

use App\Enums\StatusTable;
use App\Http\Controllers\Controller;
use App\Models\Table\Table;
use Illuminate\Http\Request;
use Throwable;
use App\HTTP\Responses\ResponseService;
use App\Models\Table\TypeTable;
use App\Services\Table\TableService;

class TableController extends Controller
{
    private Tableservice $table;


    
    public function __construct(Tableservice $table)
    {
        $this->table = $table;
    }

    public function index()
    {
        try {
            $table = Table::get();
            return ResponseService::success(" ", $table);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function show(Request $request)
    {

        try {
            $type_id = $request->type_id;
            $typeTable = TypeTable::find($type_id);
            return $typeTable->tableInternal;
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }

    public function store(Request $request)
    {

        try {
            $table = $this->table->store($request);
            return ResponseService::success(" ", "تم الاضافة بنجاح");
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
    public function update(Request $request)
    {
        try {
            $table = Table::find($request->table_id);
          // return   $table->table_status;
            if ($table->table_status == 1) {
                $table->update([
                    'table_status' => StatusTable::UNACTIVE,
                ]);
            }
            else if ($table->table_status == 0) {
                $table->update([
                    'table_status' => StatusTable::ACTIVE,
                ]);
            }
            return ResponseService::success(" you  $request->status table successfuly ", $table);
        } catch (Throwable $exception) {
            return ResponseService::error($exception->getMessage(), 'An error occurred');
        }
    }
}
