<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seletor de Imagens</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script>
        function selecionarImagem(imagem, file) {
            document.getElementById("miniatura").src = imagem;
            document.getElementById(file).checked = true; // Seleciona o input do tipo "radio" correspondente
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Formulário</h1>
        <form action="processar.php" method="post">
            <!-- Botão para abrir o modal -->
            <button type="button" class="btn btn-secondary mb-3" data-toggle="modal" data-target="#modalSeletor">Selecionar Imagens</button>

            <!-- Modal -->
            <div class="modal fade" id="modalSeletor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Seletor de Imagens</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                            <div class="row">
                                <div class="col-8">
                                    <?php
                                        $dir = '../../img/';
                                        $files = scandir($dir);
                                        foreach($files as $file) {
                                            if($file !== '.' && $file !== '..') {
                                                $imgSrc = $dir . $file;
                                                echo '<img src="' . $imgSrc . '" class="img-thumbnail mb-2" style="max-width: 100px; margin: 5px;" alt="' . $file . '" onclick="selecionarImagem(\'' . $imgSrc . '\', \'' . $file . '\')">';
                                                echo '<input type="radio" name="imagem" value="' . $file . '" class="d-none" id="' . $file . '">';
                                            }
                                        }
                                    ?>
                                </div>
                                <div class="col-4 text-center">
                                    <!-- Placeholder da miniatura -->
                                    <img id="miniatura" src="placeholder.png" class="img-thumbnail" alt="Miniatura">
                                    <button type="submit" class="btn btn-primary mt-3">Confirmar</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .modal-body::-webkit-scrollbar {
            width: 10px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
