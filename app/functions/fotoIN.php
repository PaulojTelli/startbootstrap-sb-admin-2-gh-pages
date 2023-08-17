<?php
function fotoIn($dir = '../../img/') {
    $files = scandir($dir);
    $output = '<button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#modalSeletor">Escolher Foto</button>';
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
            $output .= '<input type="radio" name="foto_in" value="' . $file . '" class="d-none" id="' . $file . '">';
        }
    }

    $output .= '</div><div class="col-4 text-center">';
    $output .= '<img id="miniatura" src="placeholder.png" class="img-thumbnail" alt="Miniatura" style="width: 250px; height: 250px;">';
    $output .= '<button type="button" class="btn btn-success" style="margin-top: 10px;" data-dismiss="modal">Confirmar</button>';
    $output .= '</div></div></div><div class="modal-footer">';
    $output .= '</div></div></div></div>';

    return $output;
}
?>
