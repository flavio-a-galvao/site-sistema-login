<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE nome = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nome);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            session_start();
            $_SESSION['usuario'] = $usuario['nome'];
            echo "Login realizado com sucesso! Bem-vindo, " . $_SESSION['usuario'];
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }
}
?>

<form method="POST">
    Nome: <input type="text" name="nome" required><br>
    Senha: <input type="password" name="senha" required><br>
    <button type="submit">Entrar</button>
</form>
