<?php require 'header.php' ?>
<?php
$id = $_GET['id'];


try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
  echo "Conexão falhou: " . $e->getMessage();
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {


  $sql = "UPDATE apartamento SET pago = 1 WHERE id = $id;";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$conn = null;
?>
<script>window.history.back();</script>
