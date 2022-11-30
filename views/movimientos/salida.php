<?php require 'views/header.php'; ?>

<div class="col-md-12">
  <div class="card card-user">
    <div class="card-header">
      <h5 class="card-title"><?php echo $this->titulo; ?></h5>
    </div>


    <?php require 'tabs.php'; ?>

    <div class="card-body">
      <form method="POST" action="<?php echo constant('URL') ?>movimientos/registrarEgreso" autocomplete="off">



        <?php if ($this->mensaje) { ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Ha ocurrido un error!</strong> <?php echo $this->mensaje; ?>
            <button type="button" class="close my-auto" data-bs-dismiss="alert" aria-label="Close">x</button>
          </div>



        <?php } ?>

        <div class="row">
          <div class="col-md-2 pr-1">
            <div class="form-group">
              <label>Referencia</label>
              <input type="hidden" name="id_producto" id="id_producto" class="form-control">
              <input type="text" name="referencia" id="referencia" onmouseover="buscar_datos();" oninput="buscar_datos();" class="form-control" value="<?php if(isset($this->producto)){echo $this->producto['referencia']; }?>" required>
            </div>
          </div>


          <div class="col-md-5 pr-1">
            <div class="form-group">
              <label>Descripcion</label>
              <input type="hidden" name="descripcion-h" id="descripcion-h" class="form-control" required>
              <input type="text" class="form-control" name="descripcion" id="descripcion" disabled required>
            </div>
          </div>

          <div class="col-md-2 pr-1">
            <div class="form-group">
              <label>Kilos Disponibles</label>
              <input type="text" class="form-control" name="kg-disp" id="kg-disp" disabled required>
            </div>
          </div>

          <div class="col-md-2 pr-1">
            <div class="form-group">
              <label>Bultos Disponibles</label>
              <input type="text" class="form-control" name="bt-disp" id="bt-disp" disabled required>
            </div>
          </div>

        </div>

        <div class="row">
          <div class="col-md-3 pr-1">
            <div class="form-group">
              <label>Bodega</label>
              <select name="bodega" id="bodega" onchange="listar_lotes()" class="form-control" required>

              </select>
            </div>
          </div>


          <div class="col-md-3 pr-1">
            <div class="form-group">
              <label>Lote</label>
              <select name="lote" id="lote" class="form-control" onchange="info_lotes()" required>

              </select>
            </div>
          </div>

          <div class="col-md-2 pr-1">
            <div class="form-group">
              <label>Kilos Disponibles</label>
              <input type="hidden" name="kg-disp-2-h" id="kg-disp-2-h" class="form-control" required>
              <input type="text" class="form-control" name="kg-disp-2" id="kg-disp-2" disabled required>
            </div>
          </div>

          <div class="col-md-2 pr-1">
            <div class="form-group">
              <label>Bultos Disponibles</label>
              <input type="hidden" name="bt-disp-2-h" id="bt-disp-2-h" class="form-control" required>
              <input type="text" class="form-control" name="bt-disp-2" id="bt-disp-2" disabled>
            </div>
          </div>


        </div>

        <div class="row">
          <div class="col-md-3 pr-1">
            <div class="form-group">
              <label>Kilos a retirar</label>
              <input type="text" name="kg-sacar" id="kg-sacar" pattern="[0-9.]{1,10}$"  class="form-control" required disabled>
            </div>
          </div>


          <div class="col-md-3 pr-1">
            <div class="form-group">
              <label>Bultos a retirar</label>
              <input required  type="text" class="form-control" name="bt-sacar" pattern="[0-9.]{1,10}$" id="bt-sacar" required disabled>
            </div>
          </div>

        </div>

        <div class="row">
        <div class="update ml-auto mr-auto">
          <button class="btn bg-gradient-primary mb-0">Retirar Producto</button>
        </div>
      </div>
      </form>

      
    </div>
  </div>
</div>

<script src="<?php echo constant('URL'); ?>public/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('.cargando').hide();
  });

  function buscar_datos() {
    referencia = $("#referencia").val();


    var parametros = {
      "buscar": "1",
      "referencia": referencia
    };
    $.ajax({
      data: parametros,
      dataType: 'json',
      minLength: 4,
      url: '<?php echo constant('URL'); ?>movimientos/buscarPorCodigo',
      type: 'post',
      error: function() {
        // alert("Error");
      },
      success: function(valores) {
        if (valores.existe == "1") {

          $("#id_producto").val(valores.id);
          $("#descripcion").val(valores.descripcion);
          $("#kg-disp").val((valores.kgdisp).toFixed(2));
          $("#bt-disp").val(valores.btdisp);
          $("#descripcion-h").val(valores.descripcion);
          document.getElementById('bodega').disabled = false;

          $("#bodega").empty();
          $("#bodega").append('<option disabled selected> Selecciona una bodega </option>');
          $.each(valores.bodegas, function(id, name) {
            $("#bodega").append('<option value=' + name.id_bodega + '>' + name.nombre + '</option>');
          });
        } else {
          $("#id_producto").val('');
          $("#descripcion-h").val('');
          $("#descripcion").val('');
          $("#kg-disp").val('');
          $("#bt-disp").val('');
          $("#kg-disp-2").val('');
          $("#bt-disp-2").val('');
          $("#kg-disp-2-h").val('');
          $("#bt-disp-2-h").val('');
          $("#lote").empty('');
          $("#bodega").empty('');
          // document.getElementById('kg-sacar').disabled = true;
          // document.getElementById('bt-sacar').disabled = true;
        }

      }
    })
  }

  function listar_lotes() {
    id = $("#id_producto").val();
    bodega = $("#bodega").val();


    var parametros = {
      "buscar": "1",
      "id": id,
      "bodega": bodega
    };
    $.ajax({
      data: parametros,
      dataType: 'json',
      url: '<?php echo constant('URL'); ?>movimientos/listarLotes',
      type: 'post',
      error: function() {},
      complete: function() {
        $('.formulario').show();
        $('.cargando').hide();

      },
      success: function(valores) {
        if (valores.existe == "1") {

          document.getElementById('lote').disabled = false;
          $("#lote").empty();
          $("#lote").append('<option disabled selected> Selecciona un lote </option>');
          // alert(valores.lotes)
          $.each(valores.lotes, function(id, name) {
            $("#lote").append('<option value=' + name.lote + '>' + 'lote ' + name.lote + '</option>');
          });
        } else {
          // alert("El propietario no existe, ¡Crealo!")
        }

      }
    })
  }

  function info_lotes() {
    id = $("#id_producto").val();
    bodega = $("#bodega").val();
    lote = $("#lote").val();

    var parametros = {
      "buscar": "1",
      "id": id,
      "bodega": bodega,
      "lote": lote
    };
    $.ajax({
      data: parametros,
      dataType: 'json',
      url: '<?php echo constant('URL'); ?>movimientos/infoLotes',
      type: 'post',
      error: function() {
        alert("Error");
      },
      complete: function() {
        $('.formulario').show();
        $('.cargando').hide();

      },
      success: function(valores) {
        if (valores.existe == "1") //Aqui usamos la variable que NO use en el vídeo
        {
          document.getElementById('kg-sacar').disabled = false;
          document.getElementById('bt-sacar').disabled = false;
          $("#kg-disp-2").val(valores.kgdisp);
          $("#bt-disp-2").val(valores.btdisp);
          $("#kg-disp-2-h").val(valores.kgdisp);
          $("#bt-disp-2-h").val(valores.btdisp);
        } else {
          // alert("El propietario no existe, ¡Crealo!")
        }

      }
    })
  }
</script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type=text]').forEach(node => node.addEventListener('keypress', e => {
      if (e.keyCode == 13) {
        e.preventDefault();
      }
    }))
  });
</script>

<script>
 
  var activo = document.getElementById("tab-salida");

   activo.classList.add('active');
   activo.classList.add('disabled');
</script>

<?php require 'views/footer.php'; ?>