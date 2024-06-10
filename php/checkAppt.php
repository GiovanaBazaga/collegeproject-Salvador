<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/checkAppt.css">
    <link rel="stylesheet" href="../css/footerStyle.css">
    <link rel="shortcut icon" href="../images/paw.png" type="image/x-icon">
    <title>Centro Vet</title>
    <script>
        function confirmDeletion(appointmentId) {
            if (confirm("Tem certeza que deseja excluir esta consulta?")) {
                window.location.href = '../php/deleteAppt.php?id=' + appointmentId;
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Clínica Veterinária Saúde Pet</h1>
    </header>

    <?php
    //Login validation
    session_start();

    if (!isset($_SESSION['user_id'])) {
        die("Acesso negado: usuário não está logado");
    }

    $user_id = $_SESSION['user_id'];

    //DB data and connection
    $server_name = "db4free.net:3306";
    $user_name = "aula_salvador224";
    $password = "teste2024";
    $database_name = "banco_salvador25";

    $conn = new mysqli($server_name, $user_name, $password, $database_name);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error . "<br>");
    }

    //SQL Query
    $sql = "
        SELECT 
            appointment.id, 
            appointment.date_day, 
            appointment.date_time, 
            pet.name AS pet_name
        FROM 
            appointment
        JOIN 
            pet ON appointment.pet_id = pet.id
        WHERE 
            appointment.client_id = ?
        ORDER BY 
            appointment.date_day, appointment.date_time";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    // Obtém o resultado
    $result = $stmt->get_result();

    echo '<div class="appointments-container">';
    if ($result->num_rows > 0) {
        echo '<div class="appointments-list">';
        while ($row = $result->fetch_assoc()) {
            echo "<div class='appointment'>";
            echo "Data: " . $row["date_day"] . " - Hora: " . $row["date_time"] . " - Nome do Pet: " . $row["pet_name"];
            echo "<button onclick=\"confirmDeletion(" . $row['id'] . ")\">Excluir</button>";
            echo "</div>";
        }
        echo '</div>';
    } else {
        echo "<div class='no-appointments'>";
        echo "<p>Nenhuma consulta marcada no momento</p>";
        echo "<button onclick=\"location.href='../pages/setAppt.html'\">Marcar Consulta</button>";
        echo "</div>";
    }
    echo '</div>';

    // Fechamentos
    $stmt->close();
    $conn->close();
    ?>

    <div class="main-buttons">
        <button class="logout-btn" onclick="location.href='../php/logout.php'">Encerrar Sessão</button>
        <button onclick="location.href='../pages/homePage.html'">Voltar</button>
    </div>
</body>

</html>