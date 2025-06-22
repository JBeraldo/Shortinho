<?php

declare(strict_types = 1); 

namespace App\Facade;

use App\Singleton\RedisConnection;
use App\Interface\RedisDriverInterface;
use App\Factory\RedisFactory;
use PDO;

class URLCache {
    static RedisDriverInterface $driver;

    public static function storeUrl(string $key, string $url): bool {
        $driver = self::getDriver();
        $ttl = $_ENV['URL_KEY_TTL'] ?: 0;
        return $driver->setURL($key,$url,$ttl);
    }

    public static function getUrl(string $key): string | bool {
        $driver = self::getDriver();
        return $driver->getURL($key);
    }

    public static function incrementURL(string $key): string | bool {
        $driver = self::getDriver();
        return $driver->incrementURL($key);
    }

    public static function getURLList(): array | bool {
        $driver = self::getDriver();
        return $driver->getURLReport();
    }

    public static function getDriver(): RedisDriverInterface {
        if (!isset(self::$driver)) {
            self::$driver = RedisFactory::make();
        }

        return self::$driver;
    }

    
}