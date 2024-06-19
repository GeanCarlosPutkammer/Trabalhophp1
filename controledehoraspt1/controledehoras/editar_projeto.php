<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $valor_hora = $_POST['valor_hora'];

    if (!empty($id) && !empty($nome) && is_numeric($valor_hora)) {
        $conn = new mysqli('localhost', 'root', '', 'controle_horas');

        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("UPDATE projetos SET nome = ?, valor_hora = ? WHERE id = ?");
        $stmt->bind_param("sdi", $nome, $valor_hora, $id);

        if ($stmt->execute()) {
            echo "Projeto atualizado com sucesso.";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Entrada inválida.";
    }
} else {
    $id = $_GET['id'];

    if (!empty($id) && is_numeric($id)) {
        $conn = new mysqli('localhost', 'root', '', 'controle_horas');

        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT nome, valor_hora FROM projetos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($nome, $valor_hora);
        $stmt->fetch();

        if (!$nome) {
            echo "Projeto não encontrado.";
            exit;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "ID inválido.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Projeto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Editar Projeto</h1>
        <form action="editar_projeto.php" method="POST" class="mt-4">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-group">
                <label for="nome">Nome do Projeto:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required>
            </div>
            <div class="form-group">
                <label for="valor_hora">Valor por Hora:</label>
                <input type="number" class="form-control" id="valor_hora" name="valor_hora" step="0.01" value="<?php echo $valor_hora; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Projeto</button>
        </form>
        <br>
        <a href="gerenciar_projetos.php" class="btn btn-secondary">Voltar</a>
    </div>
</body>
</html>
