<?php

declare(strict_types = 1); 

namespace App\Facade;

use PDO;

class PDOConnection {
    public static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $database_name = $_ENV['DB_DATABASE'];
            $database_user = $_ENV['DB_USERNAME'];
            $database_password = $_ENV['DB_PASSWORD'];

            self::$instance = new PDO("pgsql:host=db;port=5432;dbname=$database_name;user=$database_user;password=$database_password",);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }

}