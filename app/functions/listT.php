<?php

function listT()
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

      // Pago
      if ($row['pago'] == 1 && $row['locado'] == 1) {

         echo

        "<tr class='expandable-row table-success' onclick='toggleRow(\"row-details-$id\")'>
          <th>Nome:</th>
          <td>{$row['nome']}</td>
          <th>Apartamento:</th>
          <td>{$row['apartamento']}</td>
          <th>Vencimento:</th><td>{$row['vencimento_dia']}</td>
          <td colspan='4'>Pago</td> </a>
        </tr>
        <tr class='hidden-row' id='row-details-$id' style='display: none;'>
           <td colspan='7'>
           <div class='card bg-light mb-3' >
           <div class='card-header'>Informações</div>
           <div class='card-body'>
             <h5 class='card-title'>{$row['nome']} {$row['sobrenome']}</h5>
             <p class='card-text'> ID:  $id <br>
                                   Nome:  {$row['nome']} <br>
                                   preco: R$:{$row['preco']} - Pago <i class='fa-regular fa-circle-check'></i> <br>
                                   Ap:  {$row['apartamento']} <br>
                                   Dia de Vencimento:  {$row['vencimento_dia']}

                                    <div></div>
                                   <a class='btn btn-primary' target='_blank' href='https://api.whatsapp.com/send?phone=55{$row['telefone']}&text=Bom+dia%2C+{$row['nome']}' role='button'>Enviar Mensagem <i class='fa-brands fa-whatsapp'></i></a>

                                   <a class='btn btn-primary' href='\public_html\pages\perfilAp.php?id=$id.php' role='button'>Abrir Perfil <i class='fa-regular fa-address-card'></i></a>

           </div>
         </div>
         </td>
        </tr>
      ";
      }

      // Nao vencido

      if($dias <= 0 && $row['pago'] == 0 && $row['locado'] == 1) {
        echo "
        <tr class='expandable-row table-warning' onclick='toggleRow(\"row-details-$id\")'>
          <th>Nome:</th><td>{$row['nome']}</td>
          <th>Apartamento:</th><td>{$row['apartamento']}</td>
          <th>Vencimento:</th><td>{$row['vencimento_dia']}</td>
          <td colspan='4'>Ainda não venceu</td>
        </tr>
        <tr class='hidden-row' id='row-details-$id' style='display: none;'>
          <td colspan='7'>
          <div class='card bg-light mb-3' >
           <div class='card-header'>Informações</div>
           <div class='card-body'>
             <h5 class='card-title'>{$row['nome']} {$row['sobrenome']}</h5>
             <p class='card-text'> ID:  $id <br>
                                   Nome:  {$row['nome']} <br>
                                   preco: R$:{$row['preco']} - Devendo <i class='fa-regular fa-bell'></i> <br>
                                   Ap:  {$row['apartamento']} <br>
                                   Dia de Vencimento:  {$row['vencimento_dia']}

                                   <div></div>
                                   <a class='btn btn-primary' target='_blank' href='https://api.whatsapp.com/send?phone=55{$row['telefone']}&text=Bom+dia%2C+{$row['nome']}.+Pague+o+seu+preco+no+valor+de+R%24%3A{$row['preco']}%2C+antes+que+gere+multa' role='button'>Enviar Mensagem <i class='fa-brands fa-whatsapp'></i></a>
                                   <a class='btn btn-primary' href='\public_html\pages\perfilAp.php?id=$id.php' role='button'>Abrir Perfil <i class='fa-regular fa-address-card'></i></a>
                                   <a id='btnPagre' class='btn btn-primary' href='/public_html/control/pay.php?id=$id' role='button'>Registrar Pagamento <i class='fa-solid fa-cash-register'></i></a>
           </div>
         </div>
          </td>
        </tr>
        ";

      }

      // Atrassado
      if($dias > 0 && $row['pago'] == 0 && $row['locado'] == 1 ){

        echo "
        <tr class='expandable-row table-danger' onclick='toggleRow(\"row-details-$id\")'>
          <th>Nome:</th><td>{$row['nome']}</td>
          <th>Apartamento:</th><td>{$row['apartamento']}</td>
          <th>Vencimento:</th><td>{$row['vencimento_dia']}</td>
          <th>Dias sem pagar:</th><td>{$dias}</td>
          <th>Total devido:</th><td>{$total}</td>
        </tr>
        <tr class='hidden-row' id='row-details-$id' style='display: none;'>
          <td colspan='7'>
          <div class='card bg-light mb-3' >
           <div class='card-header'>Informações</div>
           <div class='card-body'>
             <h5 class='card-title'>{$row['nome']} {$row['sobrenome']}</h5>
             <p class='card-text'> ID:  $id <br>
                                   Nome:  {$row['nome']} <br>
                                   preco: R$:{$row['preco']} - Atrasado {$dias} dias <i class='fa-solid fa-triangle-exclamation'></i> <br>
                                   Ap:  {$row['apartamento']} <br>
                                   Dia de Vencimento:  {$row['vencimento_dia']} <br>

                                   <div></div>
              <a class='btn btn-primary' target='_blank' href='https://api.whatsapp.com/send?phone=55{$row['telefone']}&text=Bom+dia%2C+{$row['nome']}.+Seu+preco+esta+atrasado+{$dias}+dias%2C+e+por+isso+gerou+multa.+O+valor+atual+do+preco+%C3%A9+R%24{$total}' role='button'>Enviar Mensagem <i class='fa-brands fa-whatsapp'></i></a>

              <a class='btn btn-primary ' href='\public_html\pages\perfilAp.php?id=$id.php' role='button'>Abrir Perfil <i class='fa-regular fa-address-card'></i></a>

              <a id='btnPagre' class='btn btn-primary' href='/public_html/control/pay.php?id=$id' role='button'>Registrar Pagamento <i class='fa-solid fa-cash-register'></i></a>

</div>

          </form>
           </div>
         </div>
          </td>
        </tr>";
      }

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
                                   Aluguel: R$:{$row['preco']}
                                   <div></div>
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

