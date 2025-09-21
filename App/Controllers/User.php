<?php
// app/Models/User.php

namespace App\Models;

class User {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function findByUsername($nome) {
        $sql = "SELECT * FROM usuarios WHERE nome = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->num_rows > 0 ? $resultado->fetch_assoc() : null;
    }

    public function create($nome, $senha) {
        $sql = "INSERT INTO usuarios (nome, senha) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $nome, $senha);
        return $stmt->execute();
    }
}