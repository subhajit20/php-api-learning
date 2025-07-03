<?php

namespace Config;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    public static function connect(): PDO {
        if (self::$connection === null) {
            try {
                $host = '127.0.0.1';
                $db   = 'testdb';
                $user = 'root';
                $pass = 'mysql@2025';
                $charset = 'utf8mb4';

                $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ];

                self::$connection = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
            }
        }

        return self::$connection;
    }
}
