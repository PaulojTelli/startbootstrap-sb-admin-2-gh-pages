<?php

/**
 * Summary of vagarAp
 * deixa o ap vago
 * @param mixed $id_apartamento
 * @return void
 */
function vagarAp($id_apartamento)
{
  global $servername, $username, $password, $dbname;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  } catch (PDOException $e) {
    echo "Conexão falhou: " . $e->getMessage();
  }

  $stmt = $conn->prepare("UPDATE apartamento SET locado = 0 WHERE id = :id_apartamento");
  $stmt->bindParam(':id_apartamento', $id_apartamento);
  $stmt->execute();

  $conn = null;
}


//  -------------------funcoes de historico------------//
//historico de pagamento apartamento relacionado a inquilino
function historicoPagamentoApI($id_inquilino,$id_apartamento)
{
  global $servername, $username, $password, $dbname;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT hp.*, a.apartamento, i.nome AS nome_inquilino, i.sobrenome AS sobrenome_inquilino
            FROM historico_pagamentos AS hp
            JOIN apartamento AS a ON hp.id_apartamento = a.id
            JOIN inquilinos AS i ON hp.id_inquilino = i.id
            WHERE hp.id_apartamento = :id_apartamento AND hp.id_inquilino = :id_inquilino";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_apartamento', $id_apartamento, PDO::PARAM_INT);
    $stmt->bindParam(':id_inquilino', $id_inquilino, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="table">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th>Nome</th>';
    echo '<th>Sobrenome</th>';
    echo '<th>Apartamento</th>';
    echo '<th>Quantia Paga</th>';
    echo '<th>Aluguel</th>';
    echo '<th>Atrasados</th>';
    echo '<th>Total</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($result as $row) {
      $class = ($row['quantia_devida_acumulada'] > 0) ? 'table-danger' : 'table-success';
      echo '<tr class="' . $class . '">';
      echo '<td>' . $row['nome_inquilino'] . '</td>';
      echo '<td>' . $row['sobrenome_inquilino'] . '</td>';
      echo '<td>' . $row['apartamento'] . '</td>';
      echo '<td>' . $row['quantia_paga'] . '</td>';
      echo '<td>' . $row['quantia_devida']  . '</td>';
      echo '<td>' . $row['quantia_devida_acumulada'] . '</td>';
      echo '<td>' . $row['quantia_devida_acumulada'] + $row['quantia_devida']. '</td>';
      echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

  } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
  }
}




//historico de pagamentos de um inquilino
function historicoPagamentoInq($id_inquilino)
{
  global $servername, $username, $password, $dbname;




  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT hp.*, a.apartamento, i.nome AS nome_inquilino, i.sobrenome AS sobrenome_inquilino
            FROM historico_pagamentos AS hp
            JOIN apartamento AS a ON hp.id_apartamento = a.id
            JOIN inquilinos AS i ON hp.id_inquilino = i.id
            WHERE hp.id_inquilino = :id_inquilino";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_inquilino', $id_inquilino, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $nomeInquilino = $result[0]['nome_inquilino'];
    $sobrenomeInquilino = $result[0]['sobrenome_inquilino'];

    echo '<div>';
    echo '<h3>Historio de pagamento do inquilino:' . $nomeInquilino . ' ' . $sobrenomeInquilino . '</h3>';

    echo '<table class="table">';
    echo '<thead class="thead-dark">';
    echo '<tr>';

    echo '<th>Apartamento</th>';
    echo '<th>Mes Referente</th>';
    echo '<th>Quantia Paga</th>';
    echo '<th>Quantia Devida</th>';
    echo '<th>Atrasados</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($result as $row) {
      $class = ($row['quantia_devida'] > $row['quantia_paga']) ? 'table-danger' : 'table-success';
      echo '<tr class="' . $class . '">';

      echo '<td>' . $row['apartamento'] . '</td>';
      echo '<td>' . $row['mes_referente'] . '</td>';
      echo '<td>' . $row['quantia_paga'] . '</td>';
      echo '<td>' . $row['quantia_devida'] . '</td>';
      echo '<td>' . $row['quantia_devida_acumulada'] . '</td>';
      echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

  } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
  }
}

//historico de pagamento geral do apartamento
function historicoPagamentoAp($id_inquilino,$id_apartamento)
{
  global $servername, $username, $password, $dbname;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT hp.*, a.apartamento, i.nome AS nome_inquilino, i.sobrenome AS sobrenome_inquilino
            FROM historico_pagamentos AS hp
            JOIN apartamento AS a ON hp.id_apartamento = a.id
            JOIN inquilinos AS i ON hp.id_inquilino = i.id
            WHERE hp.id_apartamento = :id_apartamento AND hp.id_inquilino = :id_inquilino";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_apartamento', $id_apartamento, PDO::PARAM_INT);
    $stmt->bindParam(':id_inquilino', $id_inquilino, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="table">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th>Nome</th>';
    echo '<th>Sobrenome</th>';
    echo '<th>Apartamento</th>';
    echo '<th>Quantia Paga</th>';
    echo '<th>Quantia Devida</th>';
    echo '<th>Atrasados</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($result as $row) {
      $class = ($row['Quantia_Devida'] > 0) ? 'table-danger' : 'table-success';
      echo '<tr class="' . $class . '">';
      echo '<td>' . $row['nome_inquilino'] . '</td>';
      echo '<td>' . $row['sobrenome_inquilino'] . '</td>';
      echo '<td>' . $row['apartamento'] . '</td>';
      echo '<td>' . $row['Quantia_Paga'] . '</td>';
      echo '<td>' . $row['Quantia_Devida'] . '</td>';
      echo '<td>' . $row['Quantia_Acumulada'] . '</td>';
      echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

  } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
  }
}
//-------------------- fim das funcoes de historico ------------///
//listar inquilinos em uma tabela//
function listarInquilinos()
{
  try {
    global $servername, $username, $password, $dbname, $id;

    $conexao = new PDO("mysql:host=$servername;dbname=$dbname", "$username", "$password");
    // Define o modo de erro do PDO para exceção
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id as id_inquilino, nome, sobrenome, telefone, foto_in FROM inquilinos";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $result = $stmt->fetchAll();

    if ($result) {
      echo '<div class="container">';
      echo '<table class="table table-striped table-hover"><thead><tr><th>ID</th><th>Nome</th><th>Sobrenome</th><th>Telefone</th><th>Foto</th></tr></thead><tbody>';

      foreach ($result as $row) {
        if ($row['nome'] != "") {
          echo '<tr onclick="document.getElementById(\'form' . $row['id_inquilino'] . '\').submit();">';
          echo '<form id="form' . $row['id_inquilino'] . '" method="post" action="/public_html\control\cadastro_inquilo_apartamento.php">';
          echo '<input type="hidden" name="id_inquilino" value="' . $row['id_inquilino'] . '">';
          echo '<input type="hidden" name="id_apartamento" value="' . $id . '">';
          echo '<td>' . $row['id_inquilino'] . '</td><td>' . $row['nome'] . '</td><td>' . $row['sobrenome'] . '</td><td>' . $row['telefone'] . '</td><td><img src="' . $row['foto_in'] . '" alt="Foto" class="img-thumbnail" width="20"/></td>';
          echo '</form>';
          echo '</tr>';
        }
      }

      echo '</tbody></table></div>';
    } else {
      echo "0 resultados";
    }
  } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
  }

  $conexao = null;
}


?>

