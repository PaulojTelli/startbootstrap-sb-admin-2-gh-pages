<?php
function image_selector($dir = 'img/') {
    $files = scandir($dir);
    $output = '<button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#modalSeletor">Selecionar Imagens</button>';
    $output .= '<div class="modal fade" id="modalSeletor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    $output .= '<div class="modal-dialog modal-lg" role="document">';
    $output .= '<div class="modal-content">';
    $output .= '<div class="modal-header">';
    $output .= '<h5 class="modal-title" id="exampleModalLabel">Seletor de Imagens</h5>';
    $output .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    $output .= '</div><div class="modal-body" style="max-height: 400px; overflow-y: auto;"><div class="row"><div class="col-8">';

    foreach($files as $file) {
        if($file !== '.' && $file !== '..') {
            $imgSrc = $dir . $file;
            $output .= '<img src="' . $imgSrc . '" class="img-thumbnail mb-2" style="max-width: 100px; margin: 5px;" alt="' . $file . '" onclick="selecionarImagem(\'' . $imgSrc . '\', \'' . $file . '\')">';
            $output .= '<input type="radio" name="imagem" value="' . $file . '" class="d-none" id="' . $file . '">';
        }
    }

    $output .= '</div><div class="col-4 text-center">';
    $output .= '<img id="miniatura" src="placeholder.png" class="img-thumbnail" alt="Miniatura" style="width: 100px; height: 100px;">';
    $output .= '<button type="submit" class="btn btn-primary mt-3">Confirmar</button>';
    $output .= '</div></div></div><div class="modal-footer">';
    $output .= '<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
    $output .= '</div></div></div></div>';

    return $output;
}
?>
