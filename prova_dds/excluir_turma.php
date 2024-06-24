<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['turma_id'])) {
    $turma_id = $_GET['turma_id'];
    $conn = new mysqli('localhost', 'root', '', 'tb_escola');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verificar se a turma tem atividades
    $atividades_sql = "SELECT * FROM atividades WHERE turma_id = $turma_id";
    $atividades_result = $conn->query($atividades_sql);

    if ($atividades_result->num_rows > 0) {
        echo "Você não pode excluir uma turma com atividades cadastradas.";
    } else {
        $sql = "DELETE FROM turmas WHERE id = $turma_id";
        if ($conn->query($sql) === TRUE) {
            header('Location: professor_dashboard.php');
        } else {
            echo "Erro ao excluir a turma: " . $conn->error;
        }
    }

    $conn->close();
}
?>
