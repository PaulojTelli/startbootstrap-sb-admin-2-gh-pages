<?php
require $_SERVER['DOCUMENT_ROOT'] . '/public_html/pages/header.php';

//parametros do DB
global $servername, $username, $password, $dbname;

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $telefone = $_POST['telefone'];
    $dia_pagamento = $_POST['dia_pagamento'];
    $foto_in = NULL;

    // Inserção na tabela inquilinos
    $sql = "INSERT INTO inquilinos (nome, sobrenome, telefone, foto_in) VALUES (:nome, :sobrenome, :telefone, :foto_in)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':sobrenome', $sobrenome, PDO::PARAM_STR);
    $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $stmt->bindParam(':foto_in', $foto_in, PDO::PARAM_NULL);
    $stmt->execute();

    // Pegando o ID do último inquilino inserido
    $last_id_inquilino = $pdo->lastInsertId();

    // ID do apartamento a ser atualizado
    $id_apartamento = $_POST['id_apartamento'];

    // Atualizando a tabela apartamento com o novo ID do inquilino e definindo pago como 0
    $sql = "UPDATE apartamento SET id_inquilino = :id_inquilino, locado = 1, vencimento_dia = :dia_pagamento, pago = 0 WHERE id = :id_apartamento";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_inquilino', $last_id_inquilino, PDO::PARAM_INT);
    $stmt->bindParam(':id_apartamento', $id_apartamento, PDO::PARAM_INT);
    $stmt->bindParam(':dia_pagamento', $dia_pagamento, PDO::PARAM_INT);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;

?>
<script>
    window.history.back();
</script>