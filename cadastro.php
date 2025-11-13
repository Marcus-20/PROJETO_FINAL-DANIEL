<?php
// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $nome = htmlspecialchars($_POST['nome']);
    $email = htmlspecialchars($_POST['email']);
    $telefone = htmlspecialchars($_POST['telefone']);
    $senha = htmlspecialchars($_POST['senha']); // Em um sistema real, a senha deve ser hash!

    // Aqui você faria a conexão com o banco de dados e salvaria os dados.
    // Por exemplo:
    // $conn = new mysqli("localhost", "usuario", "senha", "banco_de_dados");
    // if ($conn->connect_error) { die("Conexão falhou: " . $conn->connect_error); }
    // $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, telefone, senha) VALUES (?, ?, ?, ?)");
    // $stmt->bind_param("ssss", $nome, $email, $telefone, password_hash($senha, PASSWORD_DEFAULT));
    // $stmt->execute();
    // $stmt->close();
    // $conn->close();

    // Para demonstração, apenas exibe os dados recebidos
    echo "<script>alert('Cadastro recebido!\\nNome: $nome\\nE-mail: $email\\nTelefone: $telefone');</script>";
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
                <li><a href="index.html#servicos">Serviços</a></li>
                <li><a href="cadastro.php">Cadastro</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="cadastro">
            <h2>Crie sua Conta</h2>
            <form action="cadastro.php" method="POST"> <!-- O 'action' agora aponta para este próprio arquivo PHP -->
                <label for="nome">Nome Completo:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="telefone">Telefone:</label>
                <input type="tel" id="telefone" name="telefone">

                <label for="senha">Crie uma Senha:</label>
                <input type="password" id="senha" name="senha" required>

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