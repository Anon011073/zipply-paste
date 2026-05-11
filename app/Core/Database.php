<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    protected static $instance = null;
    protected $connection;

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';

        try {
            if ($config['driver'] === 'sqlite') {
                $this->connection = new PDO("sqlite:" . $config['sqlite']['path']);
            } else {
                $dsn = "mysql:host={$config['mysql']['host']};dbname={$config['mysql']['database']};charset=utf8mb4";
                $this->connection = new PDO($dsn, $config['mysql']['username'], $config['mysql']['password']);
            }
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }
}
