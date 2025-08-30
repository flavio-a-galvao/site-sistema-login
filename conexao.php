<?php
$host = "localhost";
$usuario = "root";
$senha = ""; // coloque sua senha do MySQL, ou deixe vazio se não tiver
$banco = "sistema_login";

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
