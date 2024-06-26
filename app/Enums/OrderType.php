<?php

namespace App\Enums;

final class OrderType
{
    const INTERNAL = 1;
    const EXTERNAL = 2;
    const LOCAL = 3;
  
   
 

    public static function getAll()
    {
        return [
            OrderType::INTERNAL,
            OrderType::EXTERNAL,
            OrderType::LOCAL, 
        ];
    }
}