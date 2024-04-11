<?php

namespace App\Helpers;

class Money{

    static function addTax($price){
        return $price * 1.2;
    }

    static function format($price){
        return number_format($price, 2);
    }

    static function addTaxAndFormat($price){
        return self::format(self::addTax($price));
    }

}
