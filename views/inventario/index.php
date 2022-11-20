<?php require 'views/header.php'; ?>


<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><?php echo $this->titulo; ?></h4>
    </div>
    <div class="card-body">


      <!-- <div class="row">
        <div class="update ml-4">
          <a class="btn bg-gradient-primary mb-0" href="<?php echo constant('URL'); ?>productos/nuevo">Agregar nuevo producto</a>

        </div>
      </div>

      <br> -->

      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0" id="table">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Imagen</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Referencia</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kilos</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bultos</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>

              <?php foreach ($this->productos as $row) {
              ?>
                <tr>
                  <td>
                    <div class="d-flex px-1 py-1">
                      <div>
                        <img src="<?php echo constant('URL'); ?>public/img/team-2.jpg" class="avatar avatar-xl me-3" alt="user1">
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['codigo']; ?></p>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['descripcion']; ?></p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['sumKilos'] . " Kg"; ?>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['sumBultos']; ?>
                  </td>



                  <td class="align-middle">
                    <a href="#" data-href="<?php echo constant('URL') . 'productos/eliminarProducto/' . $row['id_producto']; ?>" class="text-primary font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#modal-confirma-<?php echo $row['id_producto']; ?>" data-placement="top" title="Eliminar Registro">
                      <i class="far fa-eye me-2"></i>Mostrar</a>
                    </a>
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


<?php 
$i = 1;
foreach ($this->productos as $row) { ?>
  <div class="modal fade" id="modal-confirma-<?php echo $row['id_producto']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Bodegas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre de bodega</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kilos</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bultos</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>

              </thead>
              <tbody>

                <?php
                
                $bodegas = $row['bodegas'];
                foreach ($bodegas as $bodega) {
                ?>
                  <tr class="collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $i; ?>">

                    <td>
                      <p class="text-xs font-weight-bold mb-0"><?php echo $bodega['nombre']; ?></p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <p class="text-xs font-weight-bold mb-0"><?php echo $bodega['sumKilos']; ?></p>
                    </td>
                    <td class="align-middle text-center text-sm">
                      <p class="text-xs font-weight-bold mb-0"><?php echo $bodega['sumBultos']; ?></p>
                    </td>
                  </tr>

              <tbody id="flush-collapse<?php echo $i; ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">

                <?php foreach ($bodega['lotes'] as $lote) { 
                  ?>
                  <tr class="text-danger">
                    <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo "Lote " . $lote['lote']; ?></p>
                    </td>
                    <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $lote['kilos']; ?></p>
                    </td>
                    <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $lote['bultos']; ?></p>
                    </td>
                  </tr>
                <?php } 
                $i++;?>
              </tbody>
            <?php
                  
                }
            ?>
            </tbody>
            </table>
            <br>
          </div>
        </div>

      </div>
    </div>
  </div>

<?php } ?>


<?php require 'views/footer.php'; ?>