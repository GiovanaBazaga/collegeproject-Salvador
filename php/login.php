<?php 
session_start();//Inicia uma nova sessão ou resume uma sessão existente 

     

$client_email = $_GET['userEmail'];//obtém o login digitado 

$client_password = $_GET['userPassword'];//obtém a senha digitada 

 
$client_email = $_GET['userEmail'];
$client_password = $_GET['userPassword'];
//dados de acesso ao banco 

$server_name = "localhost";
$user_name = "root";
$password = "";
$database_name = "projetoSalvador";
//conexão ao banco 
$conn = new mysqli($server_name, $user_name, $password, $database_name);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error . "<br>");
}

$tenta_achar = "SELECT * FROM cliente WHERE client_email='$client_email' AND client_password='$client_password'" ; 
$resultado = $conn->query($tenta_achar); 

if ($resultado->num_rows > 0) { 
    $_SESSION['userEmail'] = $client_email; 
    $_SESSION['userPassword'] = $client_password; 
    header('location:../pages/homePage.html');//redireciona para a página de acesso 
} 

else{ 
    session_unset();//remove todas as variáveis de sessão 
    session_destroy();//destroi a sessão 

    echo "<script>  
            alert('Login ou senha incorreto'); 
            window.location.href = '../pages/login.html'; 
        </script>"; 
  } 
?>