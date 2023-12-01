<?php
require $_SERVER['DOCUMENT_ROOT'] . '/public_html/pages/header.php';

// Parâmetros do DB
global $servername, $username, $password, $dbname;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_POST['id_apartamento'];
    $apartamento = $_POST['apartamento'];
    $endereco = $_POST['endereco'];
    $preco = $_POST['preco'];
    $vencimento_dia = $_POST['vencimento_dia']; // Recebendo o novo campo

    // Preparando a consulta de atualização com o novo campo
    $stmt = $conn->prepare("UPDATE apartamento SET apartamento = :apartamento, endereco = :endereco, preco = :preco, vencimento_dia = :vencimento_dia WHERE id = :id;");
    $stmt->bindParam(':apartamento', $apartamento);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':vencimento_dia', $vencimento_dia); // Vinculando o novo parâmetro
    $stmt->bindParam(':id', $id);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
<script>
    window.history.back();
</script>