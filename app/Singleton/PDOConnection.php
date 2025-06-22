<?php

declare(strict_types = 1); 

namespace App\Singleton;

use App\Interface\ConnectionInterface;
use PDO;

class PDOConnection implements ConnectionInterface {
    public static $instance;

    public static function getInstance(): PDO {
        if (!isset(self::$instance)) {
            self::$instance = new PDO($_ENV['DATABASE_DSN']);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }

}