<?php
namespace App\Controllers;

use App\Models\Usuario;

class LoginController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // 👉 Exibe formulário de login ou processa o login
    public function login()
    {
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome  = trim($_POST['nome'] ?? '');
            $senha = $_POST['senha'] ?? '';

            if ($nome && $senha) {
                $usuarioModel = new Usuario();
                $usuario = $usuarioModel->buscarPorNome($nome);

                if ($usuario && password_verify($senha, $usuario['senha'])) {
                    $_SESSION['usuario'] = $usuario;
                    header("Location: index.php?rota=home");
                    exit;
                } else {
                    $erro = "Usuário ou senha inválidos!";
                }
            } else {
                $erro = "Preencha todos os campos!";
            }
        }

        require __DIR__ . '/../Views/login.php';
    }

    // 👉 Exibe formulário de cadastro ou processa o cadastro
    public function cadastro()
    {
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome  = trim($_POST['nome'] ?? '');
            $senha = $_POST['senha'] ?? '';

            if ($nome && $senha) {
                $usuarioModel = new Usuario();

                // impede cadastro duplicado
                if ($usuarioModel->buscarPorNome($nome)) {
                    $erro = "Esse usuário já existe!";
                } else {
                    if ($usuarioModel->criar($nome, $senha)) {
                        header("Location: index.php?rota=login");
                        exit;
                    } else {
                        $erro = "Erro ao cadastrar. Tente novamente!";
                    }
                }
            } else {
                $erro = "Preencha todos os campos!";
            }
        }

        require __DIR__ . '/../Views/cadastro.php';
    }

    // 👉 Logout
    public function logout()
    {
        session_destroy();
        header("Location: index.php?rota=login");
        exit;
    }
}
