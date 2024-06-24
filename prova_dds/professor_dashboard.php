<?php
session_start();
if (!isset($_SESSION['professor_id'])) {
    header('Location: login.php');
    exit;
}

$professor_id = $_SESSION['professor_id'];
$professor_nome = $_SESSION['professor_nome'];

$conn = new mysqli('localhost', 'root', '', 'tb_escola');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$turmas_sql = "SELECT * FROM turmas WHERE professor_id = $professor_id";
$turmas_result = $conn->query($turmas_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard do Professor</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>
<body>
    <h1>Bem-vindo, <?php echo $professor_nome; ?></h1>
    <button onclick="window.location.href='logout.php'">Sair</button>
    <button onclick="window.location.href='cadastro_turma.php'">Cadastrar Turma</button>
    <h2>Suas Turmas</h2>
    <table border="1">
        <tr>
            <th>Número da Turma</th>
            <th>Nome da Turma</th>
            <th>Atividades</th>
            <th>Ações</th>
        </tr>
        <?php while($turma = $turmas_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $turma['id']; ?></td>
                <td><?php echo $turma['nome']; ?></td>
                <td>
                    <?php
                    $atividades_sql = "SELECT * FROM atividades WHERE turma_id = " . $turma['id'];
                    $atividades_result = $conn->query($atividades_sql);
                    if ($atividades_result->num_rows > 0) {
                        while ($atividade = $atividades_result->fetch_assoc()) {
                            echo '<p>' . $atividade['descricao'] . '</p>';
                        }
                    } else {
                        echo '<p>Nenhuma atividade cadastrada</p>';
                    }
                    ?>
                </td>
                <td>
                    <button onclick="confirmExclusao(<?php echo $turma['id']; ?>)">Excluir</button>
                    <button onclick="window.location.href='cadastro_atividade.php?turma_id=<?php echo $turma['id']; ?>'">Cadastrar Atividade</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        function confirmExclusao(turmaId) {
            if (confirm('Você realmente quer excluir a turma?')) {
                window.location.href = 'excluir_turma.php?turma_id=' + turmaId;
            }
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
