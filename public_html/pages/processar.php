<?php
    if(isset($_POST['imagem'])) {
        $imagemSelecionada = $_POST['imagem'];
        echo "Nome da imagem selecionada: " . $imagemSelecionada . "<br>";
    } else {
        echo "Nenhuma imagem selecionada!";
    }
?>
