<?php
// app/Controllers/AuthController.php

namespace App\Controllers;

use App\Models\Database;
use App\Models\User;

class AuthController {
    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST['nome'];
            $senha = $_POST['senha'];

            $user = new User();
            $usuarioEncontrado = $user->findByUsername($nome);

            if ($usuarioEncontrado) {
                if (password_verify($senha, $usuarioEncontrado['senha'])) {
                    session_start();
                    $_SESSION['usuario'] = $usuarioEncontrado['nome'];
                    header("Location: /");
                    exit;
                } else {
                    echo "Senha incorreta!";
                }
            } else {
                echo "Usuário não encontrado!";
            }
        }
        
        // Se a requisição não for POST (ou se der erro), a gente exibe a view
        require_once __DIR__ . '/../Views/login.php';
    }

    public function cadastro() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nome = $_POST['nome'];
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

            $user = new User();
            if ($user->create($nome, $senha)) {
                echo "Usuário cadastrado com sucesso!";
                header("Location: /");
                exit;
            } else {
                echo "Erro ao cadastrar usuário.";
            }
        }
        
        require_once __DIR__ . '/../Views/cadastro.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /");
        exit;
    }
}