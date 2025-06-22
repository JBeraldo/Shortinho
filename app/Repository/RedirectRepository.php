<?php

declare(strict_types = 1); 

namespace App\Repository;

use App\Facade\Database;

class RedirectRepository {

    public function __construct()
    {
        // ...
    }

    public function store(string $url) : string | null 
    {
        $key = bin2hex(random_bytes(3));

        $binds[':p_url'] = $url;
        $binds[':p_key'] = $key;

        $sql = "INSERT INTO urls (url, key) VALUES (:p_url, :p_key)";

        try {

            Database::executeStatement($sql,$binds);

        } catch (\PDOException $th) {
            return null;
        }

        return $key;
    }

    public function getURLbyKey(string $key) : string | bool
    {
        $binds[':p_key'] = $key;

        $sql = "SELECT url FROM urls WHERE key = :p_key";

        try {

            $response = Database::queryFirst($sql,$binds);

        } catch (\PDOException $th) {
            return false;
        }

        $url = false;

        if($response) {
            $url = $response['url'];
            $this->incrementURL($key);
        }

        return $url;
    }

    public function getURLList() : array
    {

        $sql = "SELECT key,url,access_count database_count FROM urls";

        try {

            $response = Database::queryAll($sql);

        } catch (\PDOException $th) {
            return null;
        }

        return $response;
    }

    public function incrementURL(string $key) : string | null 
    {

        $binds[':p_key'] = $key;

        $sql = "UPDATE urls SET access_count = access_count + 1 WHERE key = :p_key";

        try {

            Database::executeStatement($sql,$binds);

        } catch (\PDOException $th) {
            return null;
        }

        return $key;
    }
}