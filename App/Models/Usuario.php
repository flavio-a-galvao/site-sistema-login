<?php
namespace App\Models;

use App\Config\Database;
use PDO;

class Usuario
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // 👉 Criar usuário (cadastro)
    public function criar($nome, $senha)
    {
        $sql = "INSERT INTO usuarios (nome, senha) VALUES (:nome, :senha)";
        $stmt = $this->conn->prepare($sql);

        // senha criptografada
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        return $stmt->execute([
            ':nome' => $nome,
            ':senha' => $hash
        ]);
    }

    // 👉 Buscar usuário por nome
    public function buscarPorNome($nome)
    {
        $sql = "SELECT * FROM usuarios WHERE nome = :nome LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':nome' => $nome]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
