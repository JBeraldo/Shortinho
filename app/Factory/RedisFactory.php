<?php

declare(strict_types = 1); 

namespace App\Factory;

use App\Driver\{RedisKeyDriver, RedisMockDriver, RedisListDriver};
use App\Singleton\RedisConnection;

use PDO;

class RedisFactory {
    public static function make() {

        $redis = RedisConnection::getInstance();
        
        $driver = match ($_ENV['REDIS_STRATEGY']) {
            "KEY" => new RedisKeyDriver($redis),
            "LIST" => new RedisListDriver($redis),
            default => new RedisMockDriver($redis)
        };

        return $driver;
    }
}