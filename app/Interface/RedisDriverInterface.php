<?php

declare(strict_types = 1); 

namespace App\Interface;

interface RedisDriverInterface {

    public function setURL(string $key, mixed $url, int $ttl = 0): bool;

    public function getURL(string $key): string | bool;

    public function getURLCount(string $key): int | bool;

    public function incrementURL(string $key, int $increment_by = 1): bool;

    public function getURLReport(): array | bool;

}