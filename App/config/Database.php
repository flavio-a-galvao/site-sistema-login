<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            try {
                $host = "localhost";
                $dbname = "sistema_login";
                $username = "root";
                $password = "";

                self::$instance = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro ao conectar: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
