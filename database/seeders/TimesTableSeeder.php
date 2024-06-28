<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $times = [12,2,4,6,8,10];

        foreach ($times as $time) {
            DB::table('times')->insert([
                'time' => $time,
                'avilable' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
