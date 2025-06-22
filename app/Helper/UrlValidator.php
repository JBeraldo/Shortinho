<?php

declare(strict_types = 1);

namespace App\Helper;

class UrlValidator
{
    public static function validate(string $value): bool
    {
        $pattern = "/^https?:\\/\\/(?:www\\.)?[-a-zA-Z0-9@:%._\\+~#=]{1,256}\\.[a-zA-Z0-9()]{1,6}\\b(?:[-a-zA-Z0-9()@:%_\\+.~#?&\\/=]*)$/";

        return (bool) preg_match($pattern,$value);
    }
}