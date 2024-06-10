<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Acesso negado: usuário não está logado");
}

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Dados de conexão com o banco de dados
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $database_name = "projetoSalvador";

    $conn = new mysqli($server_name, $user_name, $password, $database_name);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error . "<br>");
    }

    // Consulta SQL para excluir a consulta
    $sql = "DELETE FROM appointment WHERE id = ? AND client_id = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação: " . $conn->error);
    }

    $stmt->bind_param("ii", $appointment_id, $_SESSION['user_id']);

    $stmt->execute();

    // Fechamentos
    $stmt->close();
    $conn->close();

    header('Location: checkAppt.php');
    exit();
} else {
    die("ID da consulta não fornecido.");
}
?>
