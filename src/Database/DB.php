<?php

namespace App\Database;

use PDO;
use PDOException;

class DB
{
    public static function connect(): PDO
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT') ?: 5432;
        $db   = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');

        try {
            return new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
        } catch (PDOException $e) {
            die('Database connection error: ' . $e->getMessage());
        }
    }
}
