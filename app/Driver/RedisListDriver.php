<?php

declare(strict_types = 1); 

namespace App\Driver;

use App\Interface\RedisDriverInterface;
use Redis;


class RedisListDriver implements RedisDriverInterface{

    public function __construct(private Redis $redis) {
        $this->redis = $redis;
    }

    public function setURL(string $key, mixed $url, int $ttl = 0): bool
    {

        $key = $key.':URL';

        try {

            $key_exists = $this->redis->exists($key);

            if(!$key_exists) 
            {
                $this->redis->rPush($key,$url,0);

                if($ttl > 0)
                {
                    $this->redis->expire($key, $ttl);
                }
            }

        } catch (\Throwable $th) {
           return false;
        }

        return true;
    }

    public function getURL(string $key): string | bool
    {

        $key = $key.':URL';

        $url = false;

        try {

            $key_exists = $this->redis->exists($key);

            if($key_exists){

                $url = $this->redis->lindex($key,0);

            }

        } catch (\Throwable $th) {
           return false;
        }

        return $url;
    }

    public function getURLCount(string $key): int | bool
    {

        $count = 0;

        try {

            $key_exists = $this->redis->exists($key);

            if($key_exists){

                $count = (int) $this->redis->lindex($key,1);

            }

        } catch (\Throwable $th) {
           return false;
        }

        return $count;
    }

    public function incrementURL(string $key, int $increment_by = 1): bool 
    {

        $key = $key.':URL';

        try {

            $key_exists = $this->redis->exists($key);

            if($key_exists) 
            {
                $count = $this->getURLCount($key);
                $count = $this->redis->lSet($key,1,$count+1);
            }

        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }

    public function getURLReport(): array | bool
    {
        $urls = [];

        try {

            $keys = $this->redis->keys('*URL');

            foreach($keys as $key)
            {
                $pure_key = explode(':',$key)[0];
                [$url,$count] =$this->redis->lRange($key,0,1);

                $urls[$pure_key] = ["url"=> $url,"access_count"=> $count];
            }

        } catch (\Throwable $th) {
           return false;
        }

        return $urls;
    }
}