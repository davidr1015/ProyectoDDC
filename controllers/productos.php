<?php

class Productos extends Controller
{

    function __construct()
    {
        parent::__construct();
        // echo "<p>Nuevo controlador Main</p>";
        $this->view->productos = [];
        $this->view->mensaje = "";
    }


    function render()
    {
        $productos = $this->model->get();
        $this->view->productos = $productos;
        $this->view->titulo = "Productos";
        $this->view->render('productos/index');
    }


    function nuevo()
    {
        $this->view->titulo = "Nuevo Producto";
        $this->view->render('productos/nuevo');
    }


    function registrarProducto()
    {
        $referencia  = strtoupper($_POST['referencia']);
        $descripcion = $_POST['descripcion'];

        $mensaje = "";

        //Verifiva que la referencia no exista
        if ($this->model->existReference($referencia) > 0) {
            $this->view->titulo = "Nuevo Producto";
            $mensaje = "Esta refencia ya ha sido registrada anteriormente";
            $this->view->mensaje = $mensaje;
            $this->view->render('productos/nuevo');
        } else {
            if ($this->model->insert(['referencia' => $referencia, 'descripcion' => $descripcion])) {
                $mensaje = "Producto registrado correctamente";
                $this->view->mensaje = $mensaje;
                $this->render();
            } else {
                $this->view->titulo = "Nuevo Producto";
                $mensaje = "Ocurrió un error al registrar este producto";
                $this->view->mensaje = $mensaje;
                $this->view->render('productos/nuevo');
            }
        }
    }


    function verProducto($param = null)
    {
        $idProducto = $param[0];
        $producto = $this->model->getById($idProducto);

        $this->view->titulo = "Editar Producto";
        $this->view->mensaje = "";
        $this->view->producto = $producto;
        $this->view->render('productos/editar');
    }

    function actualizarProducto()
    {
        $id = $_POST['id'];
        $referencia = strtoupper($_POST['referencia']);
        $descripcion = $_POST['descripcion'];
        $registrada = false;

        $productoAct = $this->model->getById($id);

        //Verifica que la referencia no cambio
        if (strtoupper($productoAct['codigo']) == strtoupper($referencia)) {
            if ($this->model->update(['id' => $id, 'codigo' => $referencia, 'descripcion' => $descripcion])) {
                $registrada = true;
            } else {
                $this->view->mensaje = "Error al actualizar el producto";
                $producto = ['id' => $id, 'referencia' => $referencia, 'descripcion' => $descripcion];
            }
        } else {
            // Si la referencia cambio, verifica que la nueva no haya sido registrada
            if ($this->model->existReference($referencia) > 0) {
                $this->view->mensaje = "La referencia ya se encuentra registrada";
            } else {
                if ($this->model->update(['id' => $id, 'codigo' => $referencia, 'descripcion' => $descripcion])) {
                } else {
                    $this->view->mensaje = "Error al actualizar el producto";
                }
            }
        }

        $producto = ['id' => $id, 'codigo' => $referencia, 'descripcion' => $descripcion];
        $this->view->titulo = "Editar Producto";
        $this->view->producto = $producto;

        if ($registrada) {
            $this->render();
        } else {
            $this->view->render('productos/editar');
        }
    }

    function eliminarProducto($param = null)
    {
        $id = $param[0];



        if ($this->model->delete($id)) {
            $mensaje = "Alumno eliminado correctamente";
        } else {

            $mensje = "No se pudo eliminar el alumno";
        }
        $this->render();
        // echo "Se elimino " . $matricula;

        // echo "mensaje";
    }
}
