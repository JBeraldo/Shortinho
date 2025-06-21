<?php

declare(strict_types = 1); 

namespace App\Facade;

use PDO;

class PDOConnection {
    public static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new PDO("sqlite:/var/www/database/pei_database.sqlite",);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }

}