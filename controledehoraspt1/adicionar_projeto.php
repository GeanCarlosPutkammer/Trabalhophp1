<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $valor_hora = $_POST['valor_hora'];

    if (!empty($nome) && is_numeric($valor_hora)) {
        $conn = new mysqli('localhost', 'root', '', 'controle_horas');

        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO projetos (nome, valor_hora) VALUES (?, ?)");
        $stmt->bind_param("sd", $nome, $valor_hora);

        if ($stmt->execute()) {
            echo "Projeto adicionado com sucesso.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Adicionar Projeto</title>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Adicionar Projeto</h1>
        <form action="adicionar_projeto.php" method="POST" class="mt-4">
            <div class="form-group">
                <label for="nome">Nome do Projeto:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="valor_hora">Valor por Hora:</label>
                <input type="number" class="form-control" id="valor_hora" name="valor_hora" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Projeto</button>
        </form>
        <br>
        <a href="index.php" class="btn btn-secondary">Voltar para o Início</a>
    </div>
</body>
</html>

