<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Projetos e Horas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Gerenciar Projetos e Horas</h1>
        <?php
        $conn = new mysqli('localhost', 'root', '', 'controle_horas');

        if ($conn->connect_error) {
            die("Erro na conexão: " . $conn->connect_error);
        }

        $sql = "
            SELECT 
                projetos.id AS projeto_id,
                projetos.nome, 
                projetos.valor_hora, 
                registros_horas.id AS registro_id,
                registros_horas.hora_inicio,
                registros_horas.hora_fim,
                TIMESTAMPDIFF(HOUR, registros_horas.hora_inicio, registros_horas.hora_fim) AS horas_trabalhadas
            FROM 
                projetos
            LEFT JOIN 
                registros_horas ON registros_horas.projeto_id = projetos.id
            ORDER BY 
                projetos.id, registros_horas.hora_inicio
        ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-striped mt-4'>";
            echo "<thead><tr><th>Projeto</th><th>Valor por Hora</th><th>Hora de Início</th><th>Hora de Fim</th><th>Horas Trabalhadas</th><th>Ações</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . $row['valor_hora'] . "</td>";
                echo "<td>" . $row['hora_inicio'] . "</td>";
                echo "<td>" . $row['hora_fim'] . "</td>";
                echo "<td>" . $row['horas_trabalhadas'] . "</td>";
                echo "<td>
                        <div class='action-buttons'>
                            <div class='edit-buttons'>
                                <a href='editar_projeto.php?id=" . $row['projeto_id'] . "' class='btn btn-edit-yellow'>Editar Projeto</a>
                                <a href='editar_hora.php?id=" . $row['registro_id'] . "' class='btn btn-edit-yellow'>Editar Hora</a>
                            </div>
                            <div class='delete-buttons'>
                                <form action='excluir_projeto.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . $row['projeto_id'] . "'>
                                    <button type='submit' class='btn btn-danger'>Excluir Projeto</button>
                                </form>
                                <form action='excluir_hora.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . $row['registro_id'] . "'>
                                    <button type='submit' class='btn btn-danger'>Excluir Hora</button>
                                </form>
                            </div>
                        </div>
                    </td>";
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
                                                                                            