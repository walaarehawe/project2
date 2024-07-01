<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizeIds = [1, 2, 3,4,5,6];
        $typeIds = [1, 2];

        foreach ($sizeIds as $sizeId) {
            foreach ($typeIds as $typeId) {
                for ($i = 0; $i < 2; $i++) {
                    DB::table('tables')->insert([
                        'type_id' => $typeId,
                        'size_id' => $sizeId,
                        'reservation_status' => 0, // الحالة الافتراضية غير محجوز
                        'table_status' => 1, // الحالة الافتراضية نشط
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
