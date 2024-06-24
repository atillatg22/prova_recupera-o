<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['turma_id']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $turma_id = $_GET['turma_id'];

    $conn = new mysqli('localhost', 'root', '', 'tb_escola');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Proteção contra SQL Injection
    $descricao = $conn->real_escape_string($descricao);

    $sql = "INSERT INTO atividades (descricao, turma_id) VALUES ('$descricao', $turma_id)";
    if ($conn->query($sql) === TRUE) {
        header('Location: professor_dashboard.php');
    } else {
        echo "Erro ao cadastrar a atividade: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Atividade</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="content">
        <h1>Cadastrar Atividade</h1>
        <form method="post" action="">
            <label>Descrição da Atividade:</label>
            <input type="text" name="descricao" required>
            <button type="submit">Cadastrar</button>
        </form>
        <button class="logout-button" onclick="window.location.href='professor_dashboard.php'">Voltar</button>
    </div>
</body>
</html>
