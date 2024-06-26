<?php

namespace Database\Seeders;

use App\Enums\TypeTabel;
use App\Models\Table\TypeTable as TableTypeTable;
use App\Models\TypeOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = TypeTabel::getAll();
        foreach ($type as $typeorder) {
TableTypeTable::create([
        'type_name'=>$typeorder]);
        }
    }
}
