<?php

function listV()
{

  global $servername,$username,$password,$dbname;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



  } catch (PDOException $e) {
    echo "Conexão falhou: " . $e->getMessage();
  }

  $sql = "SELECT apartamento.*, inquilinos.id AS inquilino_id, inquilinos.nome, inquilinos.sobrenome, inquilinos.telefone
  FROM apartamento
  left JOIN inquilinos ON apartamento.id_inquilino = inquilinos.id;";


  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



  if ($result) {
    foreach ($result as $row) {

      $dias = date('d') - $row['vencimento_dia'];
      $juros = $dias * 15;
      $total = $juros + $row['preco'];
      $id = $row['id'];


      // Vago
      if ($row['locado'] == 0) {

        echo

        "<tr class='expandable-row table-secondary' onclick='toggleRow(\"row-details-$id\")'>

          <th>Apartamento:</th>
          <td>{$row['apartamento']}</td>
          <th>Endereço:</th>
          <td>{$row['endereco']}</td>
          <th>Aluguel</th>
          <td>{$row['preco']}</td>
          <th colspan='6'>Vago</th>

        </tr>
        <tr class='hidden-row' id='row-details-$id' style='display: none;'>
           <td colspan='7'>
           <div class='card bg-light mb-3' >
           <div class='card-header'>Informações</div>
           <div class='card-body'>
             <h5 class='card-title'>Apartamento Vago</h5>
             <p class='card-text'>
                                   Endereço: {$row['endereco']}<br>
                                   Aluguel: R$:{$row['preco']} <br>
                                   <a style='margin-top:15px;' class='btn btn-primary' href='\public_html\pages\perfilAp.php?id=$id.php' role='button'>Abrir Perfil <i class='fa-regular fa-address-card'></i></a>
           </div>
         </div>
         </td>
        </tr>
      ";
     }

    }

  }


  $conn = null;
}

?>
<!-- Form menu escondido -->
<script>
function toggleRow(id) {
  var row = document.getElementById(id);
  if (row.style.display === 'none') {
    row.style.display = 'table-row';
  } else {
    row.style.display = 'none';
  }
}
</script>
<!-- enviar id pelo botao -->
<script>
    function enviarID() {
      var id = '<?php echo $row['id']; ?>';
      document.getElementById('idInput').value = id;
      document.getElementById('formPagre').submit();
    }
  </script>

