<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "barbearia";

$mensagem = "";
$cliente = null;
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// Array de serviços para o select
$servicos_lista = [
    "Corte de Cabelo Masculino", "Barba Tradicional", "Barba Desenhada",
    "Corte e Barba Combo", "Tratamento Capilar", "Limpeza de Pele Masculina"
];

// --- Lógica de UPDATE ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $id_update = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    $telefone = htmlspecialchars($_POST['telefone']);
    $servico = htmlspecialchars($_POST['servico']);

    if ($id_update) {
        $stmt = $conn->prepare("UPDATE cadastros SET nome = ?, email = ?, telefone = ?, servico = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nome, $email, $telefone, $servico, $id_update);

        if ($stmt->execute()) {
            // Redireciona para o histórico após o sucesso
            header("Location: clientes.php?status=sucesso");
            exit();
        } else {
            $mensagem = "Erro ao atualizar o cadastro: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}

// --- Lógica para buscar dados do cliente para o formulário ---
if ($id) {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT nome, email, telefone, servico FROM cadastros WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $cliente = $result->fetch_assoc();
    } else {
        $mensagem = "Cliente não encontrado.";
    }
    $stmt->close();
    $conn->close();
} else {
    // Se não houver ID, redireciona para o histórico
    header("Location: clientes.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cadastro - Barbearia Elegance</title>
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
                <li><a href="historico_agendamentos.php">Histórico</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="editar-cadastro">
            <h2>Editar Cadastro</h2>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem-erro">
                    <p><?= $mensagem ?></p>
                </div>
            <?php endif; ?>

            <?php if ($cliente): ?>
            <form action="editar_cadastro.php" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">

                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>">

                <label for="servico">Serviço Selecionado:</label>
                <select id="servico" name="servico" required>
                    <?php foreach ($servicos_lista as $servico_item): ?>
                        <option value="<?= $servico_item ?>" <?= ($cliente['servico'] == $servico_item) ? 'selected' : '' ?>>
                            <?= $servico_item ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="button">Salvar Alterações</button>
            </form>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Barbearia Elegance. Todos os direitos reservados.</p>
    </footer>
</body>
</html>