<?php
// Array com os serviços para o menu de seleção, mantendo a consistência com outras páginas.
$servicos = [
    "Corte de Cabelo Masculino",
    "Barba Tradicional",
    "Barba Desenhada",
    "Corte e Barba Combo",
    "Tratamento Capilar",
    "Limpeza de Pele Masculina"
];

// Verifica se o formulário foi enviado via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coleta os dados do formulário
    $primeiro_nome = htmlspecialchars($_POST['primeiro_nome']);
    $email = htmlspecialchars($_POST['email']);
    $servico = htmlspecialchars($_POST['servico']);
    $horario = htmlspecialchars($_POST['horario']);

    // Aqui você poderia adicionar o código para salvar os dados em um banco de dados

    $mensagem = "Obrigado por agendar, {$primeiro_nome}! Recebemos seu pedido para o serviço '{$servico}' às {$horario}.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento - Barbearia Elegance</title>
    <!-- Link para o arquivo de estilo externo -->
    <link rel="stylesheet" href="style.css">
    <!-- Link para a fonte do Google Fonts -->
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
                <li><a href="agendamento.php">Agendamento</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="agendamento-form">
            <h2>Agende seu Horário</h2>
            <p>Preencha as informações abaixo.</p>

            <?php if (isset($mensagem)): ?>
                <div class="mensagem-sucesso">
                    <p><?php echo $mensagem; ?></p>
                </div>
            <?php endif; ?>

            <form action="agendamento.php" method="post">
                <label for="primeiro_nome">Primeiro Nome:</label>
                <input type="text" id="primeiro_nome" name="primeiro_nome" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="servico">Tipo de Serviço:</label>
                <select id="servico" name="servico" required>
                    <option value="">Escolha um serviço</option>
                    <?php foreach ($servicos as $servico_item): ?>
                        <option value="<?php echo $servico_item; ?>"><?php echo $servico_item; ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="horario">Horário:</label>
                <select id="horario" name="horario" required>
                    <option value="">Escolha um horário</option>
                    <?php for ($i = 7; $i <= 19; $i++): ?>
                        <option value="<?php echo sprintf('%02d:00', $i); ?>"><?php echo sprintf('%02d:00', $i); ?></option>
                    <?php endfor; ?>
                </select>

                <button type="submit" class="button">Agendar</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Barbearia Elegance. Todos os direitos reservados.</p>
    </footer>
</body>
</html>