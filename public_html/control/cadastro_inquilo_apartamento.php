<?php var_dump($_POST);

//  require  $_SERVER['DOCUMENT_ROOT'] . '/public_html\pages\header.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
//     $id_inquilino = $_POST['id'];

//     try {
//         $conexao = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
//         $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//         $id_apartamento = 1;

//         $sql = "UPDATE apartamento SET id_inquilino = :id_inquilino WHERE id = :id_apartamento";
//         $stmt = $conexao->prepare($sql);
//         $stmt->bindParam(':id_inquilino', $id_inquilino, PDO::PARAM_INT);
//         $stmt->bindParam(':id_apartamento', $id_apartamento, PDO::PARAM_INT);

//         $stmt->execute();

//         echo "ID do inquilino atualizado com sucesso!";
//     } catch(PDOException $e) {
//         echo "Erro: " . $e->getMessage();
//     }

//     $conexao = null;
// } else {
//     echo "ID do inquilino não recebido.";
// }

?>


