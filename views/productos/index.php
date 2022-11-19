<?php require 'views/header.php'; ?>

<div class="col-md-12">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title"><?php echo $this->titulo; ?></h4>
    </div>
    <div class="card-body">


      <div class="row">
        <div class="update ml-4">
          <a class="btn bg-gradient-primary mb-0" href="<?php echo constant('URL'); ?>productos/nuevo">Agregar nuevo producto</a>

        </div>
      </div>

      <br>

      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0" id="table">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Imagen</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Referencia</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Descripcion</th>
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
                  <td class="align-middle text-center text-sm">
                    <p class="text-xs font-weight-bold mb-0"><?php echo $row['descripcion']; ?>
                  </td>
                  <td class="align-middle text-center">
                    <a href="<?php echo constant('URL') . 'productos/verProducto/' . $row['id']; ?>" class="text-dark font-weight-bold text-xs"><i class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Editar</a>
                  </td>
                  <td class="align-middle">
                    <a href="#"  data-href="<?php echo constant('URL') . 'productos/eliminarProducto/' . $row['id']; ?>" class="text-danger font-weight-bold text-xs" data-bs-toggle="modal" data-bs-target="#modal-confirma" data-placement="top" title="Eliminar Registro">
                      <i class="far fa-trash-alt me-2"></i>Eliminar</a>
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


<div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Desea eliminar este registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-dark mb-0" data-bs-dismiss="modal">Cancelar</button>
        <a class="btn bg-gradient-danger mb-0" id="btn-ok">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<?php require 'views/footer.php'; ?>