<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablesizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [2, 4, 6];

        foreach ([1, 2] as $type) {
            foreach ($sizes as $size) {
                DB::table('tablesizes')->insert([
                    'size' => $size,
                    'type' => $type,
                    'count' =>2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
