<?php
// Array com os serviços para o menu de seleção
$servicos = [
    "Corte de Cabelo Masculino",
    "Barba Tradicional",
    "Barba Desenhada",
    "Corte e Barba Combo",
    "Tratamento Capilar",
    "Limpeza de Pele Masculina"
];

$mensagem = ""; // Variável para exibir mensagens de sucesso ou erro

// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // --- Conexão com o Banco de Dados ---
    $servername = "127.0.0.1";
    $username = "root"; // Usuário padrão do XAMPP
    $password = ""; // Senha padrão do XAMPP é vazia
    $dbname = "barbearia"; // O banco de dados que você criou

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Coleta e limpa os dados do formulário
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    $telefone = htmlspecialchars($_POST['telefone']);
    $servico_selecionado = htmlspecialchars($_POST['servico']);

    // Prepara e executa a inserção no banco
    $stmt = $conn->prepare("INSERT INTO cadastros (nome, email, telefone, servico) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $telefone, $servico_selecionado);

    if ($stmt->execute()) {
        $mensagem = "Cadastro realizado com sucesso!";
    } else {
        $mensagem = "Erro ao realizar o cadastro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbearia Elegance - Cadastro</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
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
        <section id="cadastro">
            <h2>Crie sua Conta</h2>

            <?php if (!empty($mensagem)): ?>
                <div class="mensagem-sucesso" style="text-align: center; padding: 10px; margin-bottom: 20px; background-color: #d4edda; color: #155724; border-radius: 5px;">
                    <p><?php echo $mensagem; ?></p>
                </div>
            <?php endif; ?>

            <form action="cadastro.php" method="POST"> <!-- O 'action' agora aponta para este próprio arquivo PHP -->
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone">

                <label for="servico">Selecione um dos serviços:</label>
                <select id="servico" name="servico" required>
                    <option value="" disabled selected>-- Escolha um serviço --</option>
                    <?php foreach ($servicos as $servico): ?>
                        <option value="<?php echo $servico; ?>"><?php echo $servico; ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit">Finalizar Cadastro</button>
            </form>
            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">Ao se cadastrar, você concorda com nossos termos de uso e política de privacidade.</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Barbearia Elegance. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
