<?php
// app/Models/Database.php

namespace App\Models;

use mysqli;

class Database {
    private static $conn;

    public static function getConnection() {
        if (self::$conn === null) {
            $host = "localhost";
            $usuario = "root";
            $senha = ""; // Coloque sua senha do MySQL aqui
            $banco = "sistema_login";

            self::$conn = new mysqli($host, $usuario, $senha, $banco);

            if (self::$conn->connect_error) {
                die("Erro na conexão: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}