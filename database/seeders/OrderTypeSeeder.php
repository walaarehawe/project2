<?php

namespace Database\Seeders;

use App\Enums\OrderType;
use App\Models\Order\Order;
use App\Models\Order\TypeOrder as OrderTypeOrder;
use App\Models\TypeOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function PHPSTORM_META\type;

class OrderTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $type = OrderType::getAll();
        foreach ($type as $typeorder) {
            OrderTypeOrder::create([
                'type'=>$typeorder]);
        }
    }
}
