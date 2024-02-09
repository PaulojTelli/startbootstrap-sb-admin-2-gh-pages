<?php
require $_SERVER['DOCUMENT_ROOT'] . '/public_html/pages/header.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_historico = $_POST['id_historico'];

        // Primeiro, obtém o id do apartamento para o histórico específico
        $stmt = $conn->prepare("SELECT id_apartamento FROM historico_pagamentos WHERE id = :id_historico");
        $stmt->bindParam(':id_historico', $id_historico, PDO::PARAM_INT);
        $stmt->execute();
        $apartamentoData = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_apartamento = $apartamentoData['id_apartamento'];

        // Zerar a quantia restante
        $stmt = $conn->prepare("UPDATE historico_pagamentos SET quantia_restante = 0 WHERE id = :id_historico");
        $stmt->bindParam(':id_historico', $id_historico, PDO::PARAM_INT);
        $stmt->execute();

        // Encontrar o registro mais recente para este apartamento
        $stmt = $conn->prepare("SELECT id FROM historico_pagamentos WHERE id_apartamento = :id_apartamento ORDER BY data_pagamento DESC LIMIT 1");
        $stmt->bindParam(':id_apartamento', $id_apartamento, PDO::PARAM_INT);
        $stmt->execute();
        $recentRecord = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_recente = $recentRecord['id'];

        // Diminuir em 1 o valor de meses atrasados do registro mais recente
        $stmt = $conn->prepare("UPDATE historico_pagamentos SET meses_atrasados = GREATEST(0, meses_atrasados - 1) WHERE id = :id_recente");
        $stmt->bindParam(':id_recente', $id_recente, PDO::PARAM_INT);
        $stmt->execute();

        // Redirecionar para outra página ou mostrar uma mensagem de sucesso
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}

$conn = null;
?>
<script>
    window.history.back();
</script>