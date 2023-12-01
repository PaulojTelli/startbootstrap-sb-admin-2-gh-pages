<?php
require $_SERVER['DOCUMENT_ROOT'] . '/public_html/pages/header.php';

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Conexão falhou: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Iniciar transação
  $conn->beginTransaction();

  try {
    // Obter o id do apartamento, a quantia paga e o valor total do POST
    $id_apartamento = $_POST['id'];
    $quantia_paga = $_POST['quantia_paga'];
    $valor_total = $_POST['valor_total']; // Valor total recebido via POST

    // Obter o id do inquilino para o apartamento
    $stmt = $conn->prepare("SELECT id_inquilino FROM apartamento WHERE id = :id_apartamento");
    $stmt->bindParam(':id_apartamento', $id_apartamento);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_inquilino = $result['id_inquilino']; // Id do inquilino
    $stmt->closeCursor();

    // Calcular a quantia restante
    $quantia_restante = $valor_total - $quantia_paga;

    // Calcular meses atrasados
    $meses_atrasados = $quantia_restante > 0 ? 1 : 0;

    // Data atual
    $data_pagamento = date('Y-m-d');

    // Atualizar a tabela apartamento
    $stmt = $conn->prepare("UPDATE apartamento SET pago = :pago WHERE id = :id_apartamento");
    $pago = $quantia_restante <= 0 ? 1 : 0;
    $stmt->bindParam(':pago', $pago);
    $stmt->bindParam(':id_apartamento', $id_apartamento);
    $stmt->execute();

    // Inserir na tabela historico_pagamentos
    $stmt = $conn->prepare("INSERT INTO historico_pagamentos (id_apartamento, id_inquilino, data_pagamento, quantia_paga, quantia_devida, quantia_restante, meses_atrasados) VALUES (:id_apartamento, :id_inquilino, :data_pagamento, :quantia_paga, :valor_total, :quantia_restante, :meses_atrasados)");
    $stmt->bindParam(':id_apartamento', $id_apartamento);
    $stmt->bindParam(':id_inquilino', $id_inquilino);
    $stmt->bindParam(':data_pagamento', $data_pagamento);
    $stmt->bindParam(':quantia_paga', $quantia_paga);
    $stmt->bindParam(':valor_total', $valor_total);
    $stmt->bindParam(':quantia_restante', $quantia_restante);
    $stmt->bindParam(':meses_atrasados', $meses_atrasados);
    $stmt->execute();

    // Comprometer a transação
    $conn->commit();
  } catch (Exception $e) {
    // Em caso de erro, reverter a transação
    $conn->rollback();
    echo "Erro: " . $e->getMessage();
  }
}

$conn = null;
?>
<script>
  window.history.back();
</script>