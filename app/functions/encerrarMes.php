<?php
function encerrarMes()
{
    global $servername, $username, $password, $dbname;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Incrementar meses atrasados apenas para apartamentos que estão atualmente não pagos
        $sql = "UPDATE historico_pagamentos hp
JOIN apartamento a ON hp.id_apartamento = a.id
SET hp.meses_atrasados = hp.meses_atrasados + 1
WHERE a.pago = 0 AND hp.data_pagamento = (SELECT MAX(data_pagamento) FROM historico_pagamentos WHERE id_apartamento = a.id)";
        $conn->exec($sql);

        // Resetar o status de pagamento para todos os apartamentos no início de um novo mês
        $sql = "UPDATE apartamento SET pago = 0 WHERE pago = 1";
        $conn->exec($sql);
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }

    $conn = null;
}
