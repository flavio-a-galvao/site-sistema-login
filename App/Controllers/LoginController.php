<?php
namespace App\Controllers;

use Config\Database;
use PDO;

class LoginController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome  = trim($_POST['nome'] ?? '');
            $senha = trim($_POST['senha'] ?? '');

            if ($nome && $senha) {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE nome = ?");
                $stmt->execute([$nome]);
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($usuario && password_verify($senha, $usuario['senha'])) {
                    $_SESSION['usuario'] = [
                        'id'   => $usuario['id'],
                        'nome' => $usuario['nome']
                    ];
                    header('Location: index.php?rota=home');
                    exit;
                } else {
                    $erro = "Nome ou senha inválidos.";
                }
            }
        }

        require __DIR__ . '/../Views/login.php';
    }

    public function cadastro()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome  = trim($_POST['nome'] ?? '');
            $senha = trim($_POST['senha'] ?? '');

            if ($nome && $senha) {
                $pdo = Database::getConnection();
                $stmt = $pdo->prepare("INSERT INTO usuarios (nome, senha) VALUES (?, ?)");
                $stmt->execute([$nome, password_hash($senha, PASSWORD_DEFAULT)]);
                header('Location: index.php?rota=login');
                exit;
            }
        }

        require __DIR__ . '/../Views/cadastro.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?rota=login');
        exit;
    }
}
