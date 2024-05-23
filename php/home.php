<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/hpStyle.css">
    <link rel="shortcut icon" href="../images/favicon.webp" type="image/x-icon">
    <title>Vet</title>
</head>

<body>
    <header>
        <h1>Veterinária por amor</h1>
    </header>
    <main>
        <p>Os dados foram enviados e sua consulta foi marcada!</p>
    </main>

    <?php
    $server_name = "localhost";
    $user_name = "root";
    $password = "";
    $database_name = "projetoSalvador";

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
    $stmt_pet = $conn->prepare("INSERT INTO pet (pet_name, pet_type, pet_gender) VALUES (?, ?, ?)");
    $stmt_pet->bind_param("sss", $pet_name, $pet_type, $pet_gender);

    if ($stmt_pet->execute()) {
        echo "Pet inserido no banco de dados com sucesso! <br>";
    } else {
        echo "Não foi possível inserir seu pet no nosso banco de dados, por favor confira os dados informados!" . $stmt_pet->error . "<br>";
    }

    //Sending appt data
    $stmt_appt = $conn->prepare("INSERT INTO appointment (date_day, date_time) VALUES (?, ?)");
    $stmt_appt->bind_param("ss", $appt_date, $appt_time);

    if($stmt_appt->execute()){
        echo "Nova consulta marcada com sucesso! <br>";
    } else {
        echo "Erro ao tentar marcar a consulta: " . $stmt_appt->error . "<br>";
    }


    $stmt_pet->close();
    $stmt_appt->close();
    $conn->close();
    ?>

</body>

</html>