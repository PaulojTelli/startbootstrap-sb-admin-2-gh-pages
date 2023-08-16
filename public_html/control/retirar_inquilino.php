<?php require  $_SERVER['DOCUMENT_ROOT'] . '/public_html\pages\header.php' ?>
<?php
 //parametros do DB
 global $servername,$username,$password,$dbname;


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pago = isset($_POST['pago']) ? 1 : 0;
    $id_apartamento = $_POST['id_apartamento'];
    $id_inquilino = $_POST['id_inquilino'];
//atualizar condicao de locado
    $stmt = $conn->prepare("UPDATE apartamento SET locado = 0 WHERE id = :id_apartamento");
    $stmt->bindParam(':id_apartamento', $id_apartamento);
    $stmt->execute();
//tirar o inquilino do apartamento
    $stmt = $conn->prepare("UPDATE apartamento SET id_inquilino = null WHERE id = :id_apartamento");
    $stmt->bindParam(':id_apartamento', $id_apartamento);
    $stmt->execute();

$conn = null;
    ?><script>window.history.back();</script> <?php

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
$conn = null;
}
?>
