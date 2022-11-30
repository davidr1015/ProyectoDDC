<?php require 'views/header.php'; ?>


<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><?php echo $this->titulo; ?></h4>
    </div>
  <?php require 'tabs.php'; ?>

    <div class="card-body">


      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0" id="table">
            <thead>
              <tr>
               
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">Referencia</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bodega</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lote</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kilos</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bultos</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipo</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($this->movimientos as $row) {
              ?>
                <tr>
                  
                  <td>
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['referencia']; ?></p>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['descripcion']; ?></p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['nombre_bodega']; ?>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo "Lote " . $row['lote']; ?>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['kilos']. " Kg"; ?>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['bultos']. " Bultos"; ?>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['tipo']; ?>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['fecha']; ?>
                  </td>



                
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="<?php echo constant('URL');?>public/js/evitar-envio.js"></script>

<script>
 
  var activo = document.getElementById("tab-lista");
   activo.classList.add('active');
   activo.classList.add('disabled');
</script>

<?php require 'views/footer.php'; ?>