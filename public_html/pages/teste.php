<?php require 'header.php' ?>
<?php require 'sidebar.php' ?>


<form action="" method="post">
    <div class="form-group">
        <label for="nome">id inquilino</label>
        <input type="text" class="form-control" name="id_inquilino" placeholder="Digite seu nome">
    </div>
    <div class="form-group">
        <label for="email">id ap</label>
        <input type="text" class="form-control" name="id_apartamento" placeholder="Digite seu e-mail">
    </div>
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>
<?php
// historicoPagamentoApI()
historicoPagamentoAp()
    ?>

