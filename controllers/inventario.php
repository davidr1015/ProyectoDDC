<?php

class Inventario extends Controller
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
        $productos = $this->model->getProducts();
        $pr = [];

        foreach ($productos as $producto) {
            $id_producto = $producto['id_producto'];
            $id_bodega = $this->model->getBodegas($id_producto);
            $bg = [];


            foreach ($id_bodega as $bodega) {
                $lotes = $this->model->getLotes(['idProducto' => $id_producto, 'idBodega' => $bodega['id_bodega']]);

                $bodega['lotes'] = $lotes;

                // var_dump($bodega['lotes']);
                // echo "<br>";
                array_push($bg, $bodega);

                // var_dump($lotes);
                // echo "<br>";
            }
            $producto['bodegas'] = $bg;

            array_push($pr, $producto);
        }



        $this->view->productos = $pr;
        $this->view->titulo = "Inventario";
        $this->view->render('inventario/index');
    }


    function nuevo()
    {
        $this->view->titulo = "Nuevo Producto";
        $this->view->render('productos/nuevo');
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
