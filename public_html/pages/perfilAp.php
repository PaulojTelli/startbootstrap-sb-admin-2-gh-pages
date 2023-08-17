<?php require 'header.php' ?>
<?php require 'sidebar.php' ?>

<?php

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT apartamento.*, inquilinos.id, inquilinos.nome, inquilinos.sobrenome, inquilinos.telefone
  FROM apartamento
  left JOIN inquilinos ON apartamento.id_inquilino = inquilinos.id
  WHERE apartamento.id = :id;");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$result = $stmt->fetch();
$conn = null;

if ($result !== false) {
  $id_inquilino = $result['id_inquilino'];
}
?>

<div class='container' style='margin-top:20px; '>
  <h2 style='margin-bottom: 10px;'>Controle de Apartamento</h2>
  <div class='card'>
    <div class='card-body'>
      <h5 class='card-title'>Apartamento
        <?php echo $result['apartamento'] . ($result['locado'] == 1 ? ' - Locado' : ' - Vago'); ?>
      </h5>
      <p class='card-text'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-3'>
            <img src='\img\fotoAp/<?php echo $result['foto_ap'] ?>' class='img-fluid' alt='Foto do apartamento'>
          </div>
          <div class='col-md-9'>

            <p>
              <nobr>
                <form id='apartamentoForm' action='/public_html\control\atualizar_apartamento.php' method='post'>
                  <button type='button' id='editBtn' class='btn btn-outline-secondary float-right'><i
                      class='fa-solid fa-gear'></i></button>
                  <button type='submit' id='saveBtn' class='btn btn-outline-secondary float-right'
                    style='display: none;'><i class='fa-regular fa-circle-check'></i>
                    </i></button>

                  Endereço: <input type='text' class='invisible-input' name='endereco'
                    value="<?php echo $result['endereco'] ?>" disabled><br>
                  Aluguel: <input type='number' step='0.01' class='invisible-input' name='preco'
                    value="<?php echo $result['preco'] ?>" disabled><br>
                  Apartamento: <input type='number' class='invisible-input' name='apartamento'
                    value="<?php echo $result['apartamento'] ?>" disabled><br>
                  <input type='hidden' name='id_apartamento' value="<?php echo $id ?>" required>

                </form>
              </nobr>

              <hr>

            <form id='inquilinoForm' action='/public_html\control\atualizar_inquilino.php' method='post' style=" <?php if ($result['locado'] == 0) {
              echo " display:none;";
            } ?>">
              <input type='hidden' name='id_inquilino' value='<?php echo $id_inquilino; ?>' required>

              <button type='button' id='editBtnInquilino' class='btn btn-outline-secondary float-right'
                style='border:none;'><i class='fa-solid fa-gear'></i></button>

              <button type='submit' id='saveBtnInquilino' class='btn btn-outline-secondary float-right' value='Salvar'
                style='display: none;'><i class='fa-regular fa-circle-check'></i></button>
              <nobr>
                Nome: <input type='text' class='invisible-input' name='nome' value='<?php echo $result['nome'] ?>'
                  disabled><br>
                Sobrenome: <input type='text' class='invisible-input' name='sobrenome'
                  value='<?php echo $result['sobrenome'] ?>' disabled><br>

                Telefone: <input type='text' class='invisible-input' name='telefone'
                  value='<?php echo $result['telefone'] ?>' disabled><br>

            </form>
            </p>
          </div>
        </div>
      </div>
      </p>
    </div>
  </div>
  </nobr>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#editBtn').on('click', function () {
        $('#apartamentoForm input').prop('disabled', false);
        $('#apartamentoForm input').addClass('form-control');
        $('#saveBtn').show();
        $(this).hide();
      });


      $('#editBtnInquilino').on('click', function () {
        $('#inquilinoForm input').prop('disabled', false);
        $('#inquilinoForm input').addClass('form-control');
        $('#saveBtnInquilino').show();
        $(this).hide();
      });
    });
    $("#inquilinoForm").submit(function () {
      $(".invisible-input").prop('disabled', false);
    });

  </script>

  <style>
    .invisible-input {
      border: none;
      background: transparent;
      outline: none;
      width: 100%;
    }

    #editBtn {
      border: none;
      margin-bottom: 5px;
    }
  </style>

  <div class="card shadow mb-4" style="margin-top:25px;
   ">
    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button"
      aria-expanded="true" aria-controls="collapseCardExample">
      <h6 class="m-0 font-weight-bold text-primary">Cadastrar Novo Inquilino</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse hide" id="collapseCardExample">
      <div class="card-body">

        <!DOCTYPE html>
        <html>

        <body>

          <h2>Formulário de Cadastro de Inquilino</h2>

          <form action="\public_html\control\cadastro_inquilino.php" method="post">
            <!-- <input type="hidden" name="id_inquilino" value="<?php /*echo $result['id_inquilino']*/?>" required> -->
            <input type="hidden" name="id_apartamento" value="<?php echo $id ?>" required>

            <div class="form-group">
              <label for="nome">Nome:</label>
              <input type="text" class="form-control" id="nome" name="nome" required>
            </div>

            <div class="form-group">
              <label for="sobrenome">Sobrenome:</label>
              <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
            </div>

            <div class="form-group">
              <label for="telefone">Telefone:</label>
              <input type="text" class="form-control" id="telefone" name="telefone" required>
            </div>

            <div class="form-group">
              <label for="telefone">Dia de pagamento:</label>
              <input type="number" class="form-control" id="dia_pagamento" name="dia_pagamento" required>
            </div>

            <div style="display:none;">

            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </form>
        </body>

        </html>

      </div>
    </div>
  </div>


  <div class="card shadow mb-4">

    <!-- Card Header - Accordion -->
    <a href="#collapseCardExample2" class="d-block card-header py-3" data-toggle="collapse" role="button"
      aria-expanded="true" aria-controls="collapseCardExample2">
      <h6 class="m-0 font-weight-bold text-primary">Cadastrar Inquilino Antigo</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse hide" id="collapseCardExample2">
      <div class="card-body">
        <?php listarInquilinos() ?>
      </div>
    </div>
  </div>


  <?php if ($result !== false) {
    echo "
    <form id='retirar_inquilino_form' action='\public_html\control"; ?>\retirar_inquilino.php'
    <?php echo " method='post'>
    <input type='hidden' name='id_inquilino' value='{$result['id_inquilino']}' required>
    <input type='hidden' name='id_apartamento' value='{$id}' required>
    <button type='submit' class='btn btn-primary'>Mudar para Vago</button>
</form>'";
  } ?>

  <script type="text/javascript">
    document.getElementById("retirar_inquilino_form").addEventListener("submit", function (event) {
      var result = confirm("Tem certeza que deseja mudar para vago?");
      if (!result) {
        event.preventDefault();
      }
    });
  </script>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<!-- Page level plugins -->
<!-- <script src="/vendor/chart.js/Chart.min.js"></script> -->

<!-- Page level custom scripts -->
<!-- <script src="/js/demo/chart-area-demo.js"></script>
<script src="/js/demo/chart-pie-demo.js"></script>
<script src="/js/demo/chart-bar-demo.js"></script> -->


<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="/js/sb-admin-2.min.js"></script>
