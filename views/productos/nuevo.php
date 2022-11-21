<?php require 'views/header.php'; ?>

<div class="col-md-12">
  <div class="card card-user">
    <div class="card-header">
      <h5 class="card-title"><?php echo $this->titulo; ?></h5>
    </div>
    <div class="card-body">
      <form action="<?php echo constant('URL'); ?>productos/registrarProducto" method="POST" enctype="multipart/form-data">

        <div class="row">

          <?php if ($this->mensaje) { ?>
            <div class="alert alert-danger alert-dismissible fade show text-white" role="alert">
              <strong>Ha ocurrido un error! </strong> <?php echo $this->mensaje; ?>
              <button type="button" class="close my-auto text-white" data-bs-dismiss="alert" aria-label="Close">x</button>
            </div>



          <?php } ?>

          <div class="row">
            <div class="col-md-8 pr-1">
              <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
              </div>
            </div>
          </div>

          <div class="col-md-4 pr-1">
            <div class="form-group">
              <label>Referencia</label>
              <input type="text" name="referencia" class="form-control" value="<?php if(isset($this->producto)){echo $this->producto['referencia']; }?>" required>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-6 pr-1">
            <div class="form-group">
              <label>Descripcion</label>
              <input type="text" class="form-control" name="descripcion" value="<?php if(isset($this->producto)){echo $this->producto['descripcion']; }?>" required>
            </div>
          </div>

        </div>


        <div class="row">
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn bg-gradient-primary mb-0">Agregar</button>
            <a href="<?php echo constant('URL'); ?>productos" class="btn btn-outline-secondary mb-0 ">Regresar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<?php require 'views/footer.php'; ?>