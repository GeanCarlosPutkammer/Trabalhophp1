<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Projetos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Relatório de Projetos</h1>
        <?php
        $conn = new mysqli('localhost', 'root', '', 'controle_horas');

        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $sql = "
            SELECT 
                projetos.nome, 
                projetos.valor_hora, 
                SUM(TIMESTAMPDIFF(HOUR, registros_horas.hora_inicio, registros_horas.hora_fim)) AS total_horas,
                SUM(TIMESTAMPDIFF(HOUR, registros_horas.hora_inicio, registros_horas.hora_fim)) * projetos.valor_hora AS total_valor
            FROM 
                projetos
            LEFT JOIN 
                registros_horas ON registros_horas.projeto_id = projetos.id
            GROUP BY 
                projetos.id
        ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-striped mt-4'>";
            echo "<thead><tr><th>Projeto</th><th>Total de Horas</th><th>Valor por Hora</th><th>Valor Total</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . $row['total_horas'] . "</td>";
                echo "<td>" . $row['valor_hora'] . "</td>";
                echo "<td>" . $row['total_valor'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='mt-4'>Nenhum registro encontrado.</p>";
        }

        $conn->close();
        ?>
        <br>
        <a href="index.php" class="btn btn-secondary">Voltar para o Início</a>
    </div>
</body>
</html>