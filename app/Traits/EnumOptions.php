<?php

namespace App\Traits;

trait EnumOptions {

    static function options(): array
    {
        // $array = [];
        // foreach (self::cases() as $case) {
        //     $array[$case->value] = $case->name;
        // }
        // return $array;

        return collect(self::cases())->pluck('name','value')->toArray();  
    }
}