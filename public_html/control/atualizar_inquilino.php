<?php require  $_SERVER['DOCUMENT_ROOT'] . '/public_html\pages\header.php' ?>
<?php
 //parametros do DB
 global $servername,$username,$password,$dbname;
// var_dump($_POST);

try {
    // Cria a conexão PDO usando as variáveis globais
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Dados para atualização
    $id_inquilino = $_POST['id_inquilino'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $telefone = $_POST['telefone'];

    // Prepara a instrução SQL de atualização
    $sql = "UPDATE inquilinos SET nome = :nome, sobrenome = :sobrenome, telefone = :telefone WHERE id = :id_inquilino";

    // Prepara e executa a consulta usando parâmetros nomeados
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sobrenome', $sobrenome);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':id_inquilino', $id_inquilino);

    $stmt->execute();

} catch(PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

$pdo = null;
?>
<script>window.history.back();</script>
