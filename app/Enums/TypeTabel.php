<?php

namespace App\Enums;

final class TypeTabel
{
    const INTERNAL = "internal";
    const EXTERNAL = "external";
 
  
   
 

    public static function getAll()
    {
        return [
            TypeTabel::INTERNAL,
            TypeTabel::EXTERNAL,
    
        ];
    }
}