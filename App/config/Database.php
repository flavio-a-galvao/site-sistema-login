<?php
namespace Config;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;

    public static function getConnection()
    {
        if (self::$instance === null) {
            $host = "localhost";   // 🔧 seu host
            $dbname = "seu_banco"; // 🔧 nome do banco
            $user = "root";        // 🔧 usuário
            $pass = "";            // 🔧 senha

            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
