<?php

require $_SERVER['DOCUMENT_ROOT'] . '/public_html\pages\header.php';


$id_inquilino = $_POST['id_inquilino'];
$id_apartamento = $_POST['id_apartamento'];

try {
  $conexao = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
  $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "UPDATE apartamento SET id_inquilino = :id_inquilino, locado = '1' WHERE id = :id_apartamento";
  $stmt = $conexao->prepare($sql);
  $stmt->bindParam(':id_inquilino', $id_inquilino, PDO::PARAM_INT);
  $stmt->bindParam(':id_apartamento', $id_apartamento, PDO::PARAM_INT);

  $stmt->execute();


} catch (PDOException $e) {
  echo "Erro: " . $e->getMessage();
}

$conexao = null;


?>

<script>window.history.back();</script>
