<?php
$conn = new mysqli('localhost', 'root', '', 'controle_horas');

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registro_id = $_POST['registro_id'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];

    if (!empty($registro_id) && !empty($hora_inicio) && !empty($hora_fim)) {
        $stmt = $conn->prepare("UPDATE registros_horas SET hora_inicio = ?, hora_fim = ? WHERE id = ?");
        $stmt->bind_param("ssi", $hora_inicio, $hora_fim, $registro_id);

        if ($stmt->execute()) {
            echo "Registro de hora atualizado com sucesso.";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Entrada inválida.";
    }
} elseif (isset($_GET['id'])) {
    $registro_id = $_GET['id'];

    $result = $conn->query("SELECT * FROM registros_horas WHERE id = $registro_id");
    if ($result->num_rows > 0) {
        $registro = $result->fetch_assoc();
    } else {
        die("Registro não encontrado.");
    }
} else {
    die("ID inválido.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Registro de Hora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Editar Registro de Hora</h1>
        <form action="editar_hora.php" method="POST" class="mt-4">
            <input type="hidden" name="registro_id" value="<?php echo $registro['id']; ?>">
            <div class="form-group">
                <label for="hora_inicio">Hora de Início:</label>
                <input type="datetime-local" class="form-control" id="hora_inicio" name="hora_inicio" value="<?php echo date('Y-m-d\TH:i', strtotime($registro['hora_inicio'])); ?>" required>
            </div>
            <div class="form-group">
                <label for="hora_fim">Hora de Fim:</label>
                <input type="datetime-local" class="form-control" id="hora_fim" name="hora_fim" value="<?php echo date('Y-m-d\TH:i', strtotime($registro['hora_fim'])); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
        <br>
        <a href="gerenciar_projetos.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>
</html>
