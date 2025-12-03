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
        /* Animação para o Modal */
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal.show {
            display: block;
            animation: fadeIn 0.3s ease-out;
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
            background-color: var(--surface-color);
            color: var(--text-color);
            margin: 15% auto;
            width: 90%;
            max-width: 450px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
            overflow: hidden; /* Garante que o cabeçalho não ultrapasse o border-radius */
            text-align: left; /* Alinha o texto à esquerda */
        }

        .modal-header {
            background-color: var(--secondary-color);
            padding: 15px 25px;
            color: var(--primary-color);
        }

        .modal-body {
            padding: 25px;
        }

        .modal-content h3 {
            color: inherit; /* Herda a cor do modal-header */
            margin-top: 0;
            margin-bottom: 0;
            font-size: 1.3em;
            font-weight: 600;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end; /* Alinha botões à direita */
            gap: 15px; /* Espaço entre os botões */
            margin-top: 25px;
        }
        
        .modal-actions a, .modal-actions button { 
            cursor: pointer;
            border: none;
        }
        /* Botão de cancelar mais sutil */
        .button-cancel {
            background-color: #4a4a4a;
            border-radius: 5px;
            text-decoration: none;
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
                                <td class="action-links" style="justify-content: center;">
                                    <a href="historico_agendamentos.php?acao=excluir&id=<?= $row['id'] ?>" class="button-delete delete-link">Excluir</a>
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

    <!-- Modal de Confirmação de Exclusão -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este agendamento? Esta ação não pode ser desfeita.</p>
                <div class="modal-actions">
                    <button id="cancelBtn" class="button-cancel action-links a">Cancelar</button>
                    <a id="confirmBtn" href="#" class="button-delete">Sim, Excluir</a>
                </div>
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
