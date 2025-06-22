<?php

declare(strict_types = 1); 

namespace App\Driver;

use App\Interface\RedisDriverInterface;
use Redis;


class RedisKeyDriver implements RedisDriverInterface{

    public function __construct(private Redis $redis) {
        $this->redis = $redis;
    }

    public function setURL(string $key, mixed $url, int $ttl = 0): bool
    {
        $keys = [
                    $key.':URL' => $url, 
                    $key.':CNT' => 0
        ];

        try {

            $key_count = $this->redis->exists(array_keys($keys));

            if($key_count < 2) 
            {
                $this->redis->mSet($keys);

                if($ttl > 0)
                {
                    $this->redis->expire($key.':URL', $ttl);
                    $this->redis->expire($key.':CNT', $ttl);
                }
            }

        } catch (\Throwable $th) {
           return false;
        }

        return true;
    }

    public function getURL(string $key): string | bool
    {

        $url = '';

        try {

            $url = $this->redis->get($key.':URL');

        } catch (\Throwable $th) {
           return false;
        }

        return $url;
    }

    public function getURLCount(string $key): int | bool
    {

        $count = 0;

        try {

            $count = $this->redis->get($key.':CNT');

        } catch (\Throwable $th) {
           return false;
        }

        return $count;
    }

    public function incrementURL(string $key, int $increment_by = 1): bool 
    {

        $key = $key.':CNT';

        try {

            $key_exists = $this->redis->exists($key);

            if(!$key_exists) 
            {
                throw new Exception('Key not found');
            }

            $count = $this->redis->incrBy($key,$increment_by);

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
                [$url,$count] =$this->redis->mGet([$pure_key.':URL',$pure_key.':CNT']);

                $urls[$pure_key] = ["url"=> $url,"access_count"=> $count];
            }

        } catch (\Throwable $th) {
           return false;
        }

        return $urls;
    }
}