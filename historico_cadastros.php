<?php
require_once "config.php";

// Consulta ao banco
$sql = "SELECT id, nome, email, telefone, data_cadastro FROM usuarios ORDER BY data_cadastro DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Histórico de Cadastros</title>
    <link rel="stylesheet" href="style.css">

    <style>
        .container {
            width: 80%;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th {
            background: #007bff;
            color: white;
            padding: 12px;
            text-align: left;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f1f1f1;
        }

        .voltar {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #007bff;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .voltar:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Histórico de Cadastros</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Data do Cadastro</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nome']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['telefone']}</td>
                        <td>" . date('d/m/Y H:i', strtotime($row['data_cadastro'])) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum cadastro encontrado.</td></tr>";
        }
        ?>
    </table>

    <a class="voltar" href="index.html">Voltar ao Início</a>
</div>

</body>
</html>
