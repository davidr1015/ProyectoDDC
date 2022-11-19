<?php require 'views/header.php'; ?>

<div class="col-md-12">
  <div class="card card-user">
    <div class="card-header">
      <h5 class="card-title"><?php echo $this->titulo; ?></h5>
    </div>
    <div class="card-body">
      <form action="<?php echo constant('URL'); ?>bodegas/actualizarBodega" method="POST">

        <div class="row">

          <?php if ($this->mensaje) { ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong >Ha ocurrido un error!</strong> <?php echo $this->mensaje; ?>
            <button type="button" class="close my-auto" data-bs-dismiss="alert" aria-label="Close">x</button>
          </div>
         <?php }?>

         <input type="hidden" name="id" value="<?php echo $this->bodega['id']?>" class="form-control">

          <div class="col-md-6 pr-1">
            <div class="form-group">
              <label>Referencia</label>
              <input type="text" name="nombre" value="<?php echo $this->bodega['nombre']?>" class="form-control" required>
            </div>
          </div>

        </div>
        <div class="row">
          <div class="col-md-4 pr-1">
            <div class="form-group">
              <label>Descripcion</label>
              <input type="num" class="form-control" value="<?php echo $this->bodega['num_lotes']?>" name="numLotes" required>
            </div>
          </div>

        </div>


        <div class="row">
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn bg-gradient-primary mb-0">Actualizar</button>
            <a href="<?php echo constant('URL');?>bodegas" class="btn btn-outline-secondary mb-0 ">Regresar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<?php require 'views/footer.php'; ?>