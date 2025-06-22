<?php

declare(strict_types = 1); 

namespace App\Singleton;

use App\Interface\ConnectionInterface;
use Redis;

class RedisConnection implements ConnectionInterface{
    public static $instance;

    public static function getInstance(): Redis {
        if (!isset(self::$instance)) {
            self::$instance = new Redis();
            self::$instance->pconnect($_ENV['REDIS_HOST']);
        }

        return self::$instance;
    }

}