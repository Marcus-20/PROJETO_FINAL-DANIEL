<?php
// --- Conexão com o Banco de Dados ---
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbearia";

// --- Lógica para Exclusão ---
if (isset($_GET['acao']) && $_GET['acao'] == 'excluir' && isset($_GET['id'])) {
    $conn_delete = new mysqli($servername, $username, $password, $dbname);
    if (!$conn_delete->connect_error) {
        $id_para_excluir = intval($_GET['id']);
        $stmt = $conn_delete->prepare("DELETE FROM cadastros WHERE id = ?");
        $stmt->bind_param("i", $id_para_excluir);
        $stmt->execute();
        $stmt->close();
        $conn_delete->close();
        // Redireciona para a mesma página sem os parâmetros GET para evitar re-exclusão ao recarregar
        header("Location: historico_cadastros.php");
        exit();
    }
}

$mensagem_sucesso = "";
if (isset($_GET['status']) && $_GET['status'] == 'sucesso') {
    $mensagem_sucesso = "Cadastro atualizado com sucesso!";
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// --- Busca dos dados ---
$sql = "SELECT id, nome, email, telefone, servico, data_cadastro FROM cadastros ORDER BY data_cadastro DESC";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Cadastros - Barbearia Elegance</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos para os botões de ação na tabela */
        .action-links a {
            display: inline-block;
            padding: 6px 12px;
            margin: 2px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .action-links a:hover {
            transform: translateY(-2px); /* Efeito de elevação no hover */
        }

        .button-edit {
            background-color: #ffc107; /* Amarelo */
            color: #212529;
        }
        .button-edit:hover {
            background-color: #e0a800; 
        }
        .button-delete {
            background-color: #dc3545; /* Vermelho para exclusão */
        }
        .button-delete:hover {
            background-color: #c82333;
        }
    </style>
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
                <li><a href="historico_agendamentos.php">Histórico</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="historico">
            <h2>Histórico de Cadastros</h2>

            <?php if (!empty($mensagem_sucesso)): ?>
                <div class="mensagem-sucesso" style="margin-bottom: 20px;">
                    <p><?= $mensagem_sucesso ?></p>
                </div>
            <?php endif; ?>

            <table class="history-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Serviço</th>
                        <th>Data do Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row["nome"]) ?></td>
                                <td><?= htmlspecialchars($row["email"]) ?></td>
                                <td><?= htmlspecialchars($row["telefone"]) ?></td>
                                <td><?= htmlspecialchars($row["servico"]) ?></td>
                                <td><?= date("d/m/Y H:i:s", strtotime($row["data_cadastro"])) ?></td>
                                <td class="action-links">
                                    <a href="editar_cadastro.php?id=<?= $row['id'] ?>" class="button-edit">Alterar</a>
                                    <a href="historico_cadastros.php?acao=excluir&id=<?= $row['id'] ?>" class="button-delete" onclick="return confirm('Tem certeza que deseja excluir este cadastro?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Nenhum cadastro encontrado.</td>
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
