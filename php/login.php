<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Obter os dados do formulário
        $client_email = $_POST['userEmail'];
        $client_password = $_POST['userPassword'];

        // Configurações do banco de dados
        $server_name = "localhost";
        $user_name = "root";
        $password = "";
        $database_name = "projetoSalvador";

        // Conectar ao banco de dados
        $conn = new mysqli($server_name, $user_name, $password, $database_name);

        // Verificar conexão
        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error . "<br>");
        }

        // Consulta SQL para verificar as credenciais
        $sql = "SELECT id, password FROM client WHERE email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erro na preparação: " . $conn->error);
        }

        // Bind do parâmetro
        $stmt->bind_param("s", $client_email);

        // Executar a consulta
        $stmt->execute();
        $stmt->bind_result($user_id, $db_password);
        $stmt->fetch();

        // Adicione depuração
        error_log("Email enviado: $client_email");
        error_log("Senha enviada: $client_password");
        error_log("ID do usuário encontrado: $user_id");
        error_log("Senha do banco de dados: $db_password");

        // Verificar se o usuário existe e se a senha está correta
        if ($user_id && $client_password === $db_password) {
            // Armazenar o ID do usuário na sessão
            $_SESSION['user_id'] = $user_id;
            header('Location: ../pages/homePage.html'); // Redirecionar para a página de acesso
            exit();
        } else {
            session_unset(); // Remove todas as variáveis de sessão
            session_destroy();

            echo "<script>
                alert('Login ou senha incorreto');
                window.location.href = '../pages/login.html';
              </script>";
        }

        // Fechar a declaração e a conexão
        $stmt->close();
        $conn->close();
    } else {
        echo "Método de requisição inválido.";
    }
    ?>

</body>

</html>