<?php require  $_SERVER['DOCUMENT_ROOT'] . '/public_html\pages\header.php' ?>
<?php
 //parametros do DB
 global $servername,$username,$password,$dbname;

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_POST['id_apartamento'];
    $apartamento = $_POST['apartamento'];
    $endereco = $_POST['endereco'];
    $preco = $_POST['preco'];


    $stmt = $conn->prepare("UPDATE apartamento SET apartamento = :apartamento, endereco = :endereco, preco = :preco WHERE id =:id ;");
        $stmt->bindParam(':apartamento', $apartamento);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;

?>
<script>window.history.back();</script>
