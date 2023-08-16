<?php require  'header.php' ?>
<?php require  'sidebar.php'?>

<?php
 //parametros do DB
 conn();

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $stmt = $conn->prepare("SELECT apartamento.*, inquilinos.nome, inquilinos.sobrenome, inquilinos.vencimento_dia, inquilinos.pago, inquilinos.telefone
        FROM apartamento
        JOIN inquilinos ON apartamento.id_inquilino = inquilinos.id
        WHERE apartamento.id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch();
        $conn = null;

 if($result) {

echo"
    <div class='container' style='margin-top:20px; '>
  <h2 style='margin-bottom: 10px;'>Controle de Apartamento</h2>
  <div class='card'>
    <div class='card-body'>
      <h5 class='card-title'>Apartamento {$result['apartamento']}" . ($result['locado'] == 1 ? " - Locado" : " - Vago") .  "</h5>
      <p class='card-text'>
        <div class='container'>
  <div class='row'>
    <div class='col-md-3'>";?>
      <img src='\img\residential.png'  class='img-fluid' alt='Foto do apartamento'><?PHP  echo"
    </div>
    <div class='col-md-9'>

      <p>
      <form id='apartamentoForm' action='update_apartamento.php' method='post'>
        <input type='hidden' name='id' value='{$result['id']}'>
        Endereço: <input type='text' name='endereco' value='{$result['endereco']}' disabled><br>
        Aluguel: <input type='number' step='0.01' name='preco' value='{$result['preco']}' disabled><br>";
        if ($result['locado'] == 1) {
          echo"
          Nome: <input type='text' name='nome' value='{$result['nome']}' disabled>
          Sobrenome: <input type='text' name='sobrenome' value='{$result['sobrenome']}' disabled><br>
          Telefone: <input type='text' name='telefone' value='{$result['telefone']}' disabled>";
        }
        echo"
        <button type='button' id='editBtn'>Editar</button>
        <input type='submit' id='saveBtn' value='Salvar' style='display: none;'>
      </form>
      </p>
    </div>
  </div>
</div></p>
    </div>
  </div>";
        }
    }

?>

<!-- restante do seu código -->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
$(document).ready(function() {
  $('#editBtn').on('click', function() {
    $('#apartamentoForm input').prop('disabled', false);
    $('#saveBtn').show();
    $(this).hide();
  });
});
</script>

<!-- restante do seu código -->
