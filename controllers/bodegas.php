<?php

class Bodegas extends Controller
{

    function __construct()
    {
        parent::__construct();
        // echo "<p>Nuevo controlador Main</p>";
        $this->view->bodegas = [];
        $this->view->mensaje = "";
    }


    function render()
    {
        $bodegas = $this->model->get();
        $this->view->bodegas = $bodegas;
        $this->view->titulo = "Bodegas";
        $this->view->render('bodegas/index');
    }


    function nuevo()
    {
        $this->view->titulo = "Nueva Bodega";
        $this->view->render('bodegas/nuevo');
    }


    function registrarBodega()
    {
        $nombre  = $_POST['nombre'];
        $numLotes = $_POST['numLotes'];

        $mensaje = "";

        //Verifiva que la referencia no exista

        if ($this->model->insert(['nombre' => $nombre, 'numLotes' => $numLotes])) {
            $mensaje = "Bodega registrada correctamente";
            $this->view->mensaje = $mensaje;
            $this->render();
        } else {
            $this->view->titulo = "Nueva Bodega";
            $mensaje = "Ocurrió un error al registrar esta bodega";
            $this->view->mensaje = $mensaje;
            $this->view->render('bodegas/nuevo');
        }
    }


    function verBodega($param = null)
    {
        $idBodega = $param[0];
        $bodega = $this->model->getById($idBodega);

        $this->view->titulo = "Editar Bodega";
        $this->view->mensaje = "";
        $this->view->bodega = $bodega;
        $this->view->render('bodegas/editar');
    }

    function actualizarBodega()
    {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $numLotes = $_POST['numLotes'];

        if ($this->model->update(['id' => $id, 'nombre' => $nombre, 'numLotes' => $numLotes])) {
            $this->render();
        } else {
            $this->view->mensaje = "Error al actualizar la bodega";
            $bodega = ['id' => $id, 'nombre' => $nombre, 'num_lotes' => $numLotes];
            $this->view->titulo = "Editar Bodega";
            $this->view->bodega = $bodega;
            $this->view->render('bodegas/editar');
        }
    }

    function eliminarBodega($param = null)
    {
        $id = $param[0];

        if ($this->model->delete($id)) {
            $mensaje = "Bodega eliminada correctamente";
        } else {

            $mensje = "Error al eliminar la bodega";
        }
        $this->render();
    }
}
