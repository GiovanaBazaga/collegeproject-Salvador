<?php
$server_name = "localhost";
$user_name = "root";
$password = "";
$database_name = "projetoSalvador";

$conn = new mysqli($server_name, $user_name, $password, $database_name);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error . "<br>");
}

//Form data client
$client_name = $_GET['userName'];
$client_email = $_GET['userEmail'];
$client_password = $_GET['userPassword'];
$client_number = $_GET['userNumber'];
$client_CEP = $_GET['userCEP'];

//Sending client data
$stmt_cliente = $conn->prepare("INSERT INTO cliente (client_name, client_email, client_password, client_number, client_CEP) VALUES (?, ?, ?, ?, ?)");
$stmt_cliente->bind_param("sssii", $client_name, $client_email, $client_password, $client_number, $client_CEP);

if ($stmt_cliente->execute()) {
    echo "Cliente inserido no banco de dados com sucesso! <br>";
} else {
    echo "Não foi possível inserir os dados do cliente no nosso banco de dados, por favor confira os dados informados!" . $stmt_cliente->error . "<br>";
}
$stmt_cliente->close();
$conn->close();
?>