<?php

declare(strict_types = 1); 

namespace App\Service;

use App\Facade\Database;
use App\Facade\Redis;
use App\Repository\RedirectRepository;

class RedirectService {

    public function __construct(private RedirectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(string $url) : string | bool
    {
        return $this->repository->store($url);
    }

    public function getURLbyKey(string $key) : string | bool
    {
        $url = Redis::getUrl($key);

        if(!$url)
        {
            $url = $this->repository->getURLbyKey($key);
            if($url)
            {
                Redis::storeURL($key,$url);
                Redis::incrementURL($key);
            }
        }
        else{
            Redis::incrementURL($key);
        }

        return $url;
    }

    public function getURLList() : array | bool
    {
    
        $redis_urls =  Redis::getURLList();
        $database_urls = $this->repository->getURLList();

        foreach($database_urls as &$url)
        {
            $url['redis_count'] = isset($redis_urls[$url['key']]) ? $redis_urls[$url['key']]['access_count'] : 0;
        }

        return $database_urls;
    }
}