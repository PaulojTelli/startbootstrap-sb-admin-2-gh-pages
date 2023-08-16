<?php
function novoMes()
{
    global $servername,$username,$password,$dbname;

    try {
        // Conectar ao banco de dados usando PDO
        $conexao = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

        // Definir o modo de erro do PDO como exceção
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Comando SQL para atualizar os registros
        $sql = "UPDATE inquilinos SET pago = 0 WHERE id >= 0";

        // Executar a consulta
        $conexao->exec($sql);




    } catch (PDOException $e) {
        echo "Erro na atualização: " . $e->getMessage();
    }
}

$conn = null;
?>
<!--
implementar novas funcoes;
 registro historico de pagamentos de todos os aps no mes/ano em questao
 resetar lista de pagos
 adicionar contador "meses nao pagos" pra quem nao pagou - implicaria em adicionar coisa no banco de dados ja feito
 historico atual sera puxado direto da lista atual, funcao listT()
 adicionar um lugar onde possa ser setado gastos fixos e ocasionais para controlar finanças
 -->


