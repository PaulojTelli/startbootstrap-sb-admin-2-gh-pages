
  <!-- <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'> -->
  <!-- <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script> -->
  <!-- <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js'></script> -->
  <style>
    .modal-dialog {
      max-width: 800px;
    }

    .imageContainer {
      max-height: 500px;
      overflow-y: scroll;
    }

    .thumbnail {
      width: 100%;
      height: 200px;
      margin-bottom: 20px;
    }

    img {
      width: 100px;
      height: 100px;
      margin: 5px;
    }

    .selected {
      border: 2px solid red;
    }
  </style>


  <button id='openModal' class='btn btn-primary' data-toggle='modal' style='margin: 5px;' data-target='#myModal'>Escolher imagem da galeria</button>

  <div id='myModal' class='modal fade'>
    <div class='modal-dialog'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title'>Selecione uma imagem</h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <div class='modal-body row'>
          <div id='imageContainer' class='imageContainer col-md-8'>
            <!-- Imagens preenchidas pelo jQuery abaixo -->
          </div>
          <div class='col-md-4 text-center'>
            <img id='thumbnail' class='thumbnail img-thumbnail' />
            <button id='confirmBtn' class='btn btn-success' data-dismiss='modal'>Confirmar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <form id='imageForm'>
    <input type='hidden' id='selectedImage' name='selectedImage'>
    <input type='submit' value='Enviar' class='btn btn-primary' style='margin: 5px;'>
  </form>

  <script>
    $(document).ready(function(){
      $.ajax({
        url : '/img/',
        success: function (data) {
          $(data).find('a').attr('href', function (i, val) {
            if( val.match(/\.(jpe?g|png|gif)$/) ) {
              var img = $('<img />').attr('src', val).on('click', function() {
                $('#imageContainer img').removeClass('selected');
                $(this).addClass('selected');
                $('#selectedImage').val(val);
                $('#thumbnail').attr('src', val);
              });
              $('#imageContainer').append(img);
            }
          });
        }
      });
    });
  </script>

</body>
</html>
