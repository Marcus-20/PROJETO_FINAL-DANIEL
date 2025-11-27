<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Agendamentos - Barbearia Elegance</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Barbearia Elegance</h1>
        <nav>
            <ul>
                <li><a href="index.html">Início</a></li>
                <li><a href="servicos.php">Serviços</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="agendamento.php">Agendamento</a></li>
                <li><a href="agendados.php">Histórico</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="historico">
            <h2>Histórico de Agendamentos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Configurações do banco de dados (ajuste se necessário)
                    $servername = "localhost";
                    $username = "root"; // Usuário padrão do XAMPP
                    $password = "";     // Senha padrão do XAMPP
                    $dbname = "barbearia"; // Use o nome do seu banco de dados

                    // Criar conexão
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Checar conexão
                    if ($conn->connect_error) {
                        die("<tr><td colspan='4'>Falha na conexão: " . $conn->connect_error . "</td></tr>");
                    }

                    // Query para buscar os agendamentos
                    $sql = "SELECT nome_cliente, servico, data_agendamento, hora_agendamento FROM agendamentos ORDER BY data_agendamento DESC, hora_agendamento DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Exibir dados de cada linha
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td>" . htmlspecialchars($row["nome_cliente"]) . "</td><td>" . htmlspecialchars($row["servico"]) . "</td><td>" . date("d/m/Y", strtotime($row["data_agendamento"])) . "</td><td>" . date("H:i", strtotime($row["hora_agendamento"])) . "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum agendamento encontrado.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Barbearia Elegance. Todos os direitos reservados.</p>
    </footer>
</body>
</html>