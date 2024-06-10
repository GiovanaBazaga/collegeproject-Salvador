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
$client_name = $_POST['userName'];
$client_email = $_POST['userEmail'];
$client_password = $_POST['userPassword'];
$client_number = $_POST['userNumber'];
$client_CEP = $_POST['userCEP'];

//Sending client data
$stmt_cliente = $conn->prepare("INSERT INTO client (name, email, password, number, cep) VALUES (?, ?, ?, ?, ?)");
$stmt_cliente->bind_param("sssii", $client_name, $client_email, $client_password, $client_number, $client_CEP);

if ($stmt_cliente->execute()) {
    echo "Cliente inserido no banco de dados com sucesso! <br>";
} else {
    echo "Não foi possível inserir os dados do cliente no nosso banco de dados, por favor confira os dados informados!" . $stmt_cliente->error . "<br>";
}
$stmt_cliente->close();
$conn->close();
?>