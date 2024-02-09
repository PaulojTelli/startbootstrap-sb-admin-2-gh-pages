<?php require $_SERVER['DOCUMENT_ROOT'] . '/public_html\pages\header.php' ?>
<?php
//parametros do DB
global $servername, $username, $password, $dbname;
$apartamento = $_POST['apartamento'];
$endereco = $_POST['endereco'];
$locado = 0;
$preco = $_POST['preco'];
$foto_ap = $_POST['foto_ap'];
if (!$foto_ap) {
    $foto_ap = "/img/fotoAp/residential.png";
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("INSERT INTO apartamento (apartamento, endereco, locado, preco, id_inquilino, vencimento_dia, pago, foto_ap)
    VALUES (:apartamento, :endereco, :locado, :preco, NULL, NULL, NULL, :foto_ap);");

    $stmt->bindParam(':apartamento', $apartamento);
    $stmt->bindParam(':endereco', $endereco);
    $stmt->bindParam(':locado', $locado);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':foto_ap', $foto_ap);
    $stmt->execute();
    echo "Deu boa";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;

?>
<!-- <script>window.history.back();</script> -->