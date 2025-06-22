<?php

declare(strict_types = 1); 

namespace App\Facade;

use App\Singleton\PDOConnection;
use App\Helper\TypeMatcher;
use PDO;

class Database {

    static PDO $connection;

    public static function executeStatement(string $sql, array $binds =[]) : bool {
        $connection = self::getConnection();
        $stmt = $connection->prepare($sql);

        foreach($binds as $key => &$value)
        {
            $stmt->bindParam($key,$value,TypeMatcher::match($value));
        }

        return $stmt->execute();
    }

    public static function queryAll(string $sql, array $binds = []) : array {
        $connection = self::getConnection();
        $stmt = $connection->prepare($sql);

        foreach($binds as $key => &$value)
        {
            $stmt->bindParam($key,$value,TypeMatcher::match($value));
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function queryFirst(string $sql, array $binds = []) : array | bool {
        $connection = self::getConnection();
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
        $connection = self::getConnection();
        $connection->exec("CREATE TABLE IF NOT EXISTS urls (
            id SERIAL,
            url varchar(500) NOT NULL,
            key varchar(10) NOT NULL,
            access_count int default 0,
            PRIMARY KEY (id)
        )");
    }

    public static function getConnection(): PDO {
        if (!isset(self::$connection)) {
            self::$connection = PDOConnection::getInstance();
        }

        return self::$connection;
    }

}