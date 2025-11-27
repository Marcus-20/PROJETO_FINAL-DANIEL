<?php
// --- Conexão com o Banco de Dados ---
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "barbearia";

// --- Lógica para Exclusão ---
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $conn_delete = new mysqli($servername, $username, $password, $dbname);
    if (!$conn_delete->connect_error) {
        $id_para_excluir = intval($_GET['id']);
        $stmt = $conn_delete->prepare("DELETE FROM agendamentos WHERE id = ?");
        $stmt->bind_param("i", $id_para_excluir);
        $stmt->execute();
        $stmt->close();
        $conn_delete->close();
        // Redireciona para a mesma página sem os parâmetros GET para evitar re-exclusão ao recarregar
        header("Location: historico_agendamentos.php");
        exit();
    }
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// --- Busca dos dados ---
$sql = "SELECT id, nome, email, servico, horario, data_agendamento FROM agendamentos ORDER BY data_agendamento DESC";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Agendamentos - Barbearia Elegance</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos para os botões de ação na tabela */
        .button-delete {
            background-color: #5a6268; /* Cinza mais escuro */
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }
        .button-delete:hover {
            background-color: #495057; /* Cinza ainda mais escuro no hover */
        }
    </style>
</head>
<body>
    <header>
        <h1>Barbearia Elegance</h1>
        <nav>
            <ul>
                <li><a href="index.html">Início</a></li>
                <li><a href="historico_agendamentos.php">Histórico</a></li>
                <li><a href="servicos.php">Serviços</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="agendamento.php">Agendamento</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="historico">
            <h2>Histórico de Agendamentos</h2>

            <table class="history-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Serviço</th>
                        <th>Horário Agendado</th>
                        <th>Data do Agendamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["nome"]) ?></td>
                                <td><?= htmlspecialchars($row["email"]) ?></td>
                                <td><?= htmlspecialchars($row["servico"]) ?></td>
                                <td><?= htmlspecialchars($row["horario"]) ?></td>
                                <td><?= date("d/m/Y H:i:s", strtotime($row["data_agendamento"])) ?></td>
                                <td class="action-links">
                                    <a href="historico_agendamentos.php?acao=excluir&id=<?= $row['id'] ?>" class="button-delete" onclick="return confirm('Tem certeza que deseja excluir este agendamento?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Nenhum agendamento encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Barbearia Elegance. Todos os direitos reservados.</p>
    </footer>
</body>
</html>