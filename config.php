<?php
/*
 * Arquivo de configuração para conexão com o banco de dados.
 *
 * É uma boa prática armazenar essas informações em um arquivo separado
 * para facilitar a manutenção e a segurança.
 */

// --- CONFIGURAÇÕES DO BANCO DE DADOS ---

// Servidor do banco de dados. '127.0.0.1' é geralmente mais rápido que 'localhost'
// pois evita a resolução de DNS.
define('DB_SERVER', '127.0.0.1');

// Nome de usuário do banco de dados. O padrão do XAMPP é 'root'.
define('DB_USERNAME', 'root');

// Senha do banco de dados. O padrão do XAMPP é uma senha vazia.
define('DB_PASSWORD', '');

// Nome do banco de dados que você deseja conectar.
define('DB_NAME', 'cadastro');


// --- TENTATIVA DE CONEXÃO ---

// Cria a conexão com o banco de dados usando MySQLi
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verifica se ocorreu algum erro na conexão
if ($mysqli->connect_error) {
    // Em caso de erro, encerra a execução do script e exibe a mensagem de erro.
    // Em um ambiente de produção, é recomendado registrar o erro em um log em vez de exibi-lo na tela.
    die("Erro de conexão: " . $mysqli->connect_error);
}

// Define o conjunto de caracteres para utf8mb4 para suportar caracteres especiais e emojis
$mysqli->set_charset("utf8mb4");

?>