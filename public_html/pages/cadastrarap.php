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
            <input type="number" class="form-control" id="preco" name="preco" required>
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

<script>
    document.getElementById('uploadBtn').addEventListener('click', function() {
        var formData = new FormData(document.getElementById('uploadForm'));
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/public_html/control/upload_foto_ap.php', true);

        xhr.onload = function() {
            if (this.status == 200) {
                // Atualizar a lista de imagens
                atualizarListaImagens();
            } else {
                alert('Erro no upload da imagem.');
            }
        };

        xhr.send(formData);
    });

    function atualizarListaImagens() {
        // Enviar requisição AJAX para obter a lista atualizada de imagens
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/public_html/control/listar_imagens.php', true);

        xhr.onload = function() {
            if (this.status == 200) {
                document.getElementById('listaImagens').innerHTML = this.responseText;
            }
        };

        xhr.send();
    }
</script>



<?php require 'footer.php' ?>