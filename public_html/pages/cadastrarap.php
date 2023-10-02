<?php require 'header.php' ?>
<?php require 'sidebar.php' ?>


<!-- card cadastro ap -->

<?php
$dir = $_SERVER['DOCUMENT_ROOT'] . '/img/';
$imagens = glob($dir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
?>
<div class="container mt-5">
    <h1>Cadastro de Apartamento</h1>
    <form action="\public_html\control\cadastro_apartamento.php" method="post">
        <div class="form-group">
            <label for="apartamento">Apartamento:</label>
            <input type="text" class="form-control" id="apartamento" name="apartamento" required>
        </div>
        <div class="form-group">
            <label for="endereco">Endereço:</label>
            <input type="text" class="form-control" id="endereco" name="endereco" required>
        </div>
        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="number" class="form-control" id="preco" name="preco" step="0.01" min="0" required>

        </div>
        <div class="form-group mt-4">
            <label for="foto_ap">
                <?php echo fotoAp(); ?>
            </label> <br>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
</div>
</div>
</div>



<?php require 'footer.php' ?>