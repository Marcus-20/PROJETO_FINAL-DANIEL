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
        header("Location: clientes.php");
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
    <title>Clientes - Barbearia Elegance</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Estilos para a célula de ações */
        .action-links {
            display: flex;
            gap: 8px; /* Espaço entre os botões */
            justify-content: center;
            align-items: center;
        }

        /* Estilo base para os botões de ação */
        .action-links a {
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.2s ease-in-out, transform 0.1s ease;
        }

        /* Estilos para os botões de ação na tabela */
        .button-edit {
            background-color: #ffc107; /* Amarelo */
            color: #212529;
        }
        .button-edit:hover {
            background-color: #e0a800;
        }
        .button-delete {
            background-color: #dc3545; /* Vermelho */
        }
        .button-delete:hover {
            background-color: #c82333;
        }

        /* Animação para o Modal */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-icon {
            margin-bottom: 15px;
        }


        /* Estilos para o Modal de Confirmação */
        .modal {
            display: none; /* Oculto por padrão */
            position: fixed; /* Fica sobre todo o conteúdo */
            z-index: 2000; /* Garante que fique na frente */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7); /* Fundo preto semi-transparente */
        }

        .modal-content {
            background-color: #1e1e1e; /* Cor de superfície do seu tema */
            color: #e0e0e0; /* Cor de texto do seu tema */
            margin: 15% auto;
            padding: 30px;
            border: 1px solid #2a2a2a;
            width: 90%;
            max-width: 450px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }

        .modal-content h3 {
            color: #c5a47e; /* Cor secundária do tema */
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.5em;
        }

        .modal-actions {
            display: flex;
            justify-content: center;
            gap: 15px; /* Espaço entre os botões */
            margin-top: 25px;
        }
        
        .modal-actions a, .modal-actions button { 
            cursor: pointer;
            border: none;
        }
        /* Botão de cancelar mais sutil */
        .button-cancel {
            background-color: #4a4a4a; /* Cinza escuro neutro */
        }
        .button-cancel:hover {
            background-color: #5a5a5a;
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
            <h2>Clientes Cadastrados</h2>

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
                                    <a href="clientes.php?acao=excluir&id=<?= $row['id'] ?>" class="button-delete delete-link">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align:center;">Nenhum cliente encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Modal de Confirmação de Exclusão -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <p style="font-size: 1.2em; margin-top: 10px;">Deseja excluir o seu cadastro?</p>
            <div class="modal-actions">
                <button id="cancelBtn" class="button-cancel action-links a">Não</button>
                <a id="confirmBtn" href="#" class="button-delete">Sim</a>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Barbearia Elegance. Todos os direitos reservados.</p>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('confirmModal');
        const cancelBtn = document.getElementById('cancelBtn');
        const confirmBtn = document.getElementById('confirmBtn');
        const deleteLinks = document.querySelectorAll('.delete-link');

        // Abre o modal quando qualquer link de exclusão é clicado
        deleteLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault(); // Impede a navegação imediata
                const deleteUrl = this.href; // Pega o URL de exclusão do link
                confirmBtn.href = deleteUrl; // Define o URL no botão de confirmação do modal
                modal.classList.add('show'); // Exibe o modal com animação
            });
        });

        // Fecha o modal ao clicar em "Cancelar"
        cancelBtn.addEventListener('click', function () {
            modal.classList.remove('show');
        });

        // Fecha o modal se o usuário clicar fora da caixa de diálogo
        window.addEventListener('click', function (event) {
            if (event.target == modal) {
                modal.classList.remove('show');
            }
        });
    });
    </script>
</body>
</html>
</html>

