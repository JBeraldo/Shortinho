<?php

declare(strict_types = 1); 

namespace App\Service;

use App\Facade\Database;

class RedirectService {

    public function __construct()
    {
        // ...
    }

    public function store(string $url) : string | null {
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

    public function getURLbyKey(string $key) : string | null {

        $binds[':p_key'] = $key;

        $sql = "SELECT url FROM urls WHERE key = :p_key";

        try {

        $response = Database::queryFirst($sql,$binds);
        
        } catch (\PDOException $th) {
            return null;
        }

        ["url" => $url] = $response;
 
        return $url;
    }
}