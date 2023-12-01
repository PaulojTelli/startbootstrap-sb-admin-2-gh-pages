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