<?php

declare(strict_types = 1); 

namespace Nuape\Facade;

use Nuape\Facade\Connection;
use Nuape\Helper\TypeMatcher;
use PDO;

class Database {

    public static function executeStatement(string $sql, array $binds =[]) : bool {
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);

        foreach($binds as $key => &$value)
        {
            $stmt->bindParam($key,$value,TypeMatcher::match($value));
        }

        return $stmt->execute();
    }

    public static function queryAll(string $sql, array $binds = []) : array {
        $connection = Connection::getInstance();
        $stmt = $connection->prepare($sql);

        foreach($binds as $key => &$value)
        {
            $stmt->bindParam($key,$value,TypeMatcher::match($value));
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function migrateUp(): void
    {
        $connection = Connection::getInstance();
        $connection->exec("CREATE TABLE IF NOT EXISTS confirmations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            ra TEXT NOT NULL,
            aluno TEXT NOT NULL,
            professor TEXT NOT NULL,
            email_received INTEGER NOT NULL,
            acknowledged INTEGER NOT NULL,
            confirmation_date TEXT NOT NULL
        )");
    }

}