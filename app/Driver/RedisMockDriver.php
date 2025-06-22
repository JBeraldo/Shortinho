<?php

declare(strict_types = 1); 

namespace App\Driver;

use App\Interface\RedisDriverInterface;
use Redis;


class RedisMockDriver implements RedisDriverInterface{

    public function __construct(private Redis $redis) {
        $this->redis = $redis;
    }

    public function setURL(string $key, mixed $url, int $ttl = 0): bool
    {
        return false;
    }

    public function getURL(string $key): string | bool
    {
         return false;
    }

    public function getURLCount(string $key): int 
    {  
         return false;
    }

    public function incrementURL(string $key, int $increment_by = 1): bool 
    {
        return false;
    }

    public function getURLReport(): array | bool
    {
         return false;
    }
}