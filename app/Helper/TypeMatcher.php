<?php

declare(strict_types = 1);

namespace App\Helper;
use PDO;

class TypeMatcher
{
    public static function match(mixed $value): int 
    {
        if(strtotime((string) $value))
        {
            return PDO::PARAM_STR;
        }

        return match (gettype($value)) {
            "integer" => PDO::PARAM_INT,
            "string" =>  PDO::PARAM_STR
        };
    }
}