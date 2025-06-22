<?php

declare(strict_types = 1); 

namespace App\Facade;

use App\Facade\PDOConnection;
use App\Helper\TypeMatcher;
use PDO;

class Database {

    public static function executeStatement(string $sql, array $binds =[]) : bool {
        $connection = PDOConnection::getInstance();
        $stmt = $connection->prepare($sql);

        foreach($binds as $key => &$value)
        {
            $stmt->bindParam($key,$value,TypeMatcher::match($value));
        }

        return $stmt->execute();
    }

    public static function queryAll(string $sql, array $binds = []) : array {
        $connection = PDOConnection::getInstance();
        $stmt = $connection->prepare($sql);

        foreach($binds as $key => &$value)
        {
            $stmt->bindParam($key,$value,TypeMatcher::match($value));
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function queryNext(string $sql, array $binds = []) : array | bool {
        $connection = PDOConnection::getInstance();
        $stmt = $connection->prepare($sql);

        foreach($binds as $key => &$value)
        {
            $stmt->bindParam($key,$value,TypeMatcher::match($value));
        }

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function migrateUp(): void
    {
        $connection = PDOConnection::getInstance();
        $connection->exec("CREATE TABLE IF NOT EXISTS urls (
            id SERIAL,
            url varchar(500) NOT NULL,
            key varchar(10) NOT NULL,
            access_count int default 0,
            PRIMARY KEY (id)
        )");
    }

}