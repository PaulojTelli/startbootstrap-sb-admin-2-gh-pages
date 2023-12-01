<?php

function listT()
{

  global $servername, $username, $password, $dbname;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "Conexão falhou: " . $e->getMessage();
  }

  $sql = "SELECT apartamento.*, inquilinos.id AS inquilino_id, inquilinos.nome, inquilinos.sobrenome, inquilinos.telefone,
  hp.meses_atrasados
    FROM apartamento
    LEFT JOIN inquilinos ON apartamento.id_inquilino = inquilinos.id
    LEFT JOIN (
    SELECT id_apartamento, meses_atrasados
    FROM historico_pagamentos
    WHERE data_pagamento IN (
      SELECT MAX(data_pagamento)
      FROM historico_pagamentos AS hp2
      WHERE hp2.id_apartamento = historico_pagamentos.id_apartamento
    )
    ) AS hp ON apartamento.id = hp.id_apartamento;
    ";

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



  if ($result) {
    foreach ($result as $row) {

      $dias = date('d') - $row['vencimento_dia'];
      $juros = $row['preco'] * 0.1;
      $valor_total = $juros + $row['preco'];
      $id = $row['id'];
      $valor_preco = $row['preco'];
      $mesesAtrasados = $row['meses_atrasados'] ?? 0;


      // Pago
      if ($row['pago'] == 1 && $row['locado'] == 1) {

        echo

        "<tr class='expandable-row table-success' onclick='toggleRow(\"row-details-$id\")'>
          <th>Nome:</th>
          <td>{$row['nome']}</td>
          <th>Apartamento:</th>
          <td>{$row['apartamento']}</td>
          <th>Vencimento:</th><td>{$row['vencimento_dia']}</td>
          <th>Meses Atrasados: </th><td>{$mesesAtrasados}</td>
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
                                   Preço: R$:{$row['preco']} - Pago <i class='fa-regular fa-circle-check'></i> <br>
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

      if ($dias <= 0 && $row['pago'] == 0 && $row['locado'] == 1) {
        echo "
        <tr class='expandable-row table-warning' onclick='toggleRow(\"row-details-$id\")'>
          <th>Nome:</th><td>{$row['nome']}</td>
          <th>Apartamento:</th><td>{$row['apartamento']}</td>
          <th>Vencimento:</th><td>{$row['vencimento_dia']}</td>
          <th>Meses Atrasados: </th><td>{$mesesAtrasados}</td>
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
                                   Preço: R$:{$row['preco']} - Devendo <i class='fa-regular fa-bell'></i> <br>
                                   Ap:  {$row['apartamento']} <br>
                                   Dia de Vencimento:  {$row['vencimento_dia']}

                                   <div></div>
                                   <a class='btn btn-primary' target='_blank' href='https://api.whatsapp.com/send?phone=55{$row['telefone']}&text=Bom+dia%2C+{$row['nome']}.+Pague+o+seu+preco+no+valor+de+R%24%3A{$row['preco']}%2C+antes+que+gere+multa' role='button'>Enviar Mensagem <i class='fa-brands fa-whatsapp'></i></a>
                                   <a class='btn btn-primary' href='\public_html\pages\perfilAp.php?id=$id.php' role='button'>Abrir Perfil <i class='fa-regular fa-address-card'></i></a>
                                   <a id='btnPagre' class='btn btn-primary' data-toggle='modal' data-target='#modalPagamento-$id' role='button'>
                                      Registrar Pagamento <i class='fa-solid fa-cash-register'></i>
                                   </a>
                                   
                                   <div class='modal fade' id='modalPagamento-$id' tabindex='-1' role='dialog' aria-labelledby='modalPagamentoLabel' aria-hidden='true'>
                                    <div class='modal-dialog' role='document'>
                                      <div class='modal-content'>
                                        <div class='modal-header'>
                                          <h5 class='modal-title' id='modalPagamentoLabel'>Registrar Pagamento</h5>
                                          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                            <span aria-hidden='true'>&times;</span>
                                          </button>
                                        </div>
                                        <div class='modal-body'>
                                          <form action='/public_html/control/pay.php' method='POST'>
                                            <div class='form-group'>
                                            <p>Quantida Devida: R$: $valor_preco</p>
                                              <label for='quantia_paga'>Quantia Paga:</label>
                                              <input type='number' class='form-control' id='quantia_paga' name='quantia_paga' required>
                                            </div>
                                            <input type='hidden' name='id' value='$id'>
                                            <input type='hidden' name='valor_total' id='valor_total' value='$valor_preco'>
                                            <button type='submit' class='btn btn-primary'>Confirmar Pagamento</button>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
           </div>
         </div>
          </td>
        </tr>
        ";
      }

      // Atrassado
      if ($dias > 0 && $row['pago'] == 0 && $row['locado'] == 1) {

        echo "
        <tr class='expandable-row table-danger' onclick='toggleRow(\"row-details-$id\")'>
          <th>Nome:</th><td>{$row['nome']}</td>
          <th>Apartamento:</th><td>{$row['apartamento']}</td>
          <th>Vencimento:</th><td>{$row['vencimento_dia']}</td>
          <th>Meses Atrasados: </th><td>{$mesesAtrasados}</td>

          <th>Dias sem pagar:</th><td>{$dias}</td>
          <th>Total devido:</th><td>{$valor_total}</td>
        </tr>
        <tr class='hidden-row' id='row-details-$id' style='display: none;'>
          <td colspan='7'>
          <div class='card bg-light mb-3' >
           <div class='card-header'>Informações</div>
           <div class='card-body'>
             <h5 class='card-title'>{$row['nome']} {$row['sobrenome']}</h5>
             <p class='card-text'> ID:  $id <br>
                                   Nome:  {$row['nome']} <br>
                                   Preço: R$:{$row['preco']} - Atrasado {$dias} dias <i class='fa-solid fa-triangle-exclamation'></i> <br>
                                   Ap:  {$row['apartamento']} <br>
                                   Dia de Vencimento:  {$row['vencimento_dia']} <br>
                                   
                                   <div></div>
              <a class='btn btn-primary' target='_blank' href='https://api.whatsapp.com/send?phone=55{$row['telefone']}&text=Bom+dia%2C+{$row['nome']}.+Seu+preco+esta+atrasado+{$dias}+dias%2C+e+por+isso+gerou+multa.+O+valor+atual+do+preco+%C3%A9+R%24{$valor_total}' role='button'>Enviar Mensagem <i class='fa-brands fa-whatsapp'></i></a>

              <a class='btn btn-primary' href='\public_html\pages\perfilAp.php?id=$id.php' role='button'>Abrir Perfil <i class='fa-regular fa-address-card'></i></a>

              <a id='btnPagre' class='btn btn-primary' data-toggle='modal' data-target='#modalPagamento' role='button'>
                Registrar Pagamento <i class='fa-solid fa-cash-register'></i>
              </a>

              <!-- Modal para o pagamento -->
              <div class='modal fade' id='modalPagamento' tabindex='-1' role='dialog' aria-labelledby='modalPagamentoLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title' id='modalPagamentoLabel'>Registrar Pagamento</h5>
                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                      </button>
                    </div>
                    <div class='modal-body'>
                      <form action='/public_html/control/pay.php' method='POST'>
                        <div class='form-group'>
                          <p>Quantida Devida: $valor_total</p>
                          <label for='quantia_paga'>Quantia Paga</label>
                          <input type='number' class='form-control' id='quantia_paga' name='quantia_paga' required>
                        </div>
                        <input type='hidden' name='id' value='$id'>
                        <input type='hidden' name='valor_total' id='valor_total' value='$valor_total'>
                        <button type='submit' class='btn btn-primary'>Confirmar Pagamento</button>
                      </form>
                    </div>
                  </div>
                </div>
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
<!-- <script>
  function enviarID() {
    var id = '<?php echo $row['id']; ?>';
    document.getElementById('idInput').value = id;
    document.getElementById('formPagre').submit();
  }
</script> -->