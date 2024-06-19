<?php
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    if (!empty($id) && is_numeric($id)) {
        $conn = new mysqli('localhost', 'root', '', 'controle_horas');

        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("DELETE FROM registros_horas WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $message = "Registro de hora excluído com sucesso.";
        } else {
            $message = "Erro ao excluir registro de hora: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        $message = "Entrada inválida.";
    }
} else {
    $message = "Método de requisição inválido.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Registro de Hora</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class='container'>
        <h1 class='mt-5'>Excluir Registro de Hora</h1>
        <div class='alert alert-info' role='alert'>
            <?php echo $message; ?>
        </div>
        <a href='gerenciar_projetos.php' class='btn btn-secondary'>Voltar</a>
    </div>
</body>
</html>
