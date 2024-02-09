<?php require $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT'] . 'css\style.css' ?>">
    <script src="https://kit.fontawesome.com/35ca44fdca.js" crossorigin="anonymous"></script>


    <title>Controle de Aluguéis</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href='/css/sb-admin-2.min.css' rel="stylesheet">
    <link href='/css/style.css' rel="stylesheet">

    <!-- Custom styles for this page -->
    <!-- <link href='/vendor/datatables/dataTables.bootstrap4.min.css' rel="stylesheet"> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        function selecionarImagem(imagem, filename) {
            document.getElementById("miniatura").src = imagem;
            document.getElementById(filename).checked = true;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

</head>
<?php
$servername = "localhost";
$username = "root";
$password = "Canel@2323my";
$dbname = "control";
?>