<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projeto_id = $_POST['projeto_id'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fim = $_POST['hora_fim'];

    if (!empty($projeto_id) && !empty($hora_inicio) && !empty($hora_fim)) {
        $conn = new mysqli('localhost', 'root', '', 'controle_horas');

        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO registros_horas (projeto_id, hora_inicio, hora_fim) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $projeto_id, $hora_inicio, $hora_fim);

        if ($stmt->execute()) {
            echo "Registro de hora adicionado com sucesso.";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Entrada inválida.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Registro de Hora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Adicionar Registro de Hora</h1>
        <form action="adicionar_hora.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="projeto_id">Projeto:</label>
                <select class="form-control" id="projeto_id" name="projeto_id" required>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'controle_horas');
                    if ($conn->connect_error) {
                        die("Erro na conexão: " . $conn->connect_error);
                    }

                    $result = $conn->query("SELECT id, nome FROM projetos");

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                        }
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="hora_inicio">Hora de Início:</label>
                <input type="datetime-local" class="form-control" id="hora_inicio" name="hora_inicio" required>
            </div>
            <div class="form-group">
                <label for="hora_fim">Hora de Fim:</label>
                <input type="datetime-local" class="form-control" id="hora_fim" name="hora_fim" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Registro de Hora</button>
        </form>
        <br>
        <a href="index.php" class="btn btn-secondary">Voltar para o Início</a>
    </div>
</body>
</html>
