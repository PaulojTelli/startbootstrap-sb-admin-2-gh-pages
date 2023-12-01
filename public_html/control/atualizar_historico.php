<?php
require $_SERVER['DOCUMENT_ROOT'] . '/public_html/pages/header.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Conexão falhou: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_historico = $_POST['id_historico'];
    $quantia_restante = $_POST['quantia_restante'];

    // Prepare a consulta para atualizar a quantia restante
    $sql = "UPDATE historico_pagamentos SET quantia_restante = :quantia_restante WHERE id = :id_historico";
    $stmt = $conn->prepare($sql); // Substitua $pdo por $conn
    $stmt->bindParam(':quantia_restante', $quantia_restante, PDO::PARAM_STR);
    $stmt->bindParam(':id_historico', $id_historico, PDO::PARAM_INT);
    $stmt->execute();

    // Redirecionar para outra página ou mostrar uma mensagem de sucesso
}

$conn = null;
?>
<script>
    window.history.back();
</script>