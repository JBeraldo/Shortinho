<?php

declare(strict_types = 1); 

namespace App\Interface;

interface ConnectionInterface {

    public static function getInstance(): mixed;

}