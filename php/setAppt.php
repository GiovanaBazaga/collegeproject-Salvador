<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon.webp" type="image/x-icon">
    <link rel="stylesheet" href="../css/ApptStyle.css">
    <title>Vet</title>
</head>

<body>
    <header>
        <h1>Veterinária por amor</h1>
    </header>
    <main>
        <?php
        //Login validation
        session_start();
        if (!isset($_SESSION['user_id'])) {
            die("Acesso negado: usuário não está logado.");
        }

        $user_id = $_SESSION['user_id'];

        //DB data
        $server_name = "db4free.net:3306";
        $user_name = "aula_salvador224";
        $password = "teste2024";
        $database_name = "banco_salvador25";

        $conn = new mysqli($server_name, $user_name, $password, $database_name);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error . "<br>");
        }

        //Form data pet
        $pet_name = $_GET['petName'];
        $pet_type = $_GET['petType'];
        $pet_gender = $_GET['sex'];

        //Form data appointment
        $appt_date = $_GET['apptDate'];
        $appt_time = $_GET['apptTime'];

        //Sending pet data
        $stmt_pet = $conn->prepare("INSERT INTO pet (name, type, gender, client_id) VALUES (?, ?, ?, ?)");
        $stmt_pet->bind_param("sssi", $pet_name, $pet_type, $pet_gender, $user_id);

        if ($stmt_pet->execute()) {
            echo "Pet inserido no banco de dados com sucesso! <br>";

            // Obter o ID do pet inserido
            $pet_id = $stmt_pet->insert_id;

            //Sending appointment data
            $stmt_appt = $conn->prepare("INSERT INTO appointment (date_day, date_time, client_id, pet_id) VALUES (?, ?, ?, ?)");
            $stmt_appt->bind_param("ssii", $appt_date, $appt_time, $user_id, $pet_id);

            if ($stmt_appt->execute()) {
                echo "Nova consulta marcada com sucesso! <br>";
            } else {
                echo "Erro ao tentar marcar a consulta: " . $stmt_appt->error . "<br>";
            }

            $stmt_appt->close();
        } else {
            echo "Não foi possível inserir seu pet no nosso banco de dados, por favor confira os dados informados!" . $stmt_pet->error . "<br>";
        }

        $stmt_pet->close();
        $conn->close();
        ?>

        <div class="logout-btn"><button onclick="location.href='../pages/homePage.html'">Voltar</button></div>
    </main>
</body>

</html>