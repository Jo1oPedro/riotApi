<?php

namespace App\Database;

use PDO;

class Connection
{
    private static $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];

    private static ?PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): PDO
    {
        if(is_null(self::$instance)) {
            $databaseDir = __DIR__ . "/../../sqlite/riotApi.db";
            self::$instance = new PDO("sqlite:{$databaseDir}", options: self::$options);
        }
        return self::$instance;
    }
}