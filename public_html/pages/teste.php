<?php require  'header.php' ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
        <h1>Formulário</h1>
        <form action="processar.php" method="post">
            <?php echo image_selector(); ?>
            <!-- resto do seu formulário -->
        </form>
    </div>
    <!-- resto do seu HTML -->
</body>
</html>
