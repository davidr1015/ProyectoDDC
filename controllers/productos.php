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

    function createName()
    {
        $cons = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        $cadena = "";

        $length = sizeof($cons);

        for ($i = 0; $i < 45; $i++) {

            $cadena .= $cons[rand(0, $length - 1)];
        }

        return $cadena;
    }


    function registrarProducto()
    {
        $this->view->titulo = "Nuevo Producto";
        $mensaje = "";

        $referencia  = strtoupper($_POST['referencia']);
        $descripcion = $_POST['descripcion'];

        $producto = ['referencia' => $referencia, 'descripcion' => $descripcion];
        $fotoName = $_FILES['foto']['name'];
        $foto = $_FILES['foto']['tmp_name'];
        $newFotoName = $this->createName() . "-" . $referencia . ".jpg";


        if (empty($_FILES['foto']['name'])) {
            $ruta = NULL;
        } else {
            $permitidos = array("image/jpg", "image/png", "image/jpeg");
            // echo $_FILES['foto']['type'];
            if (in_array($_FILES['foto']["type"], $permitidos)) {
                $ruta = 'fotos';
                $ruta =  $ruta . "/" . $newFotoName;
            } else {
                $mensaje = "El formato de la foto es incorrecto";
                $this->view->mensaje = $mensaje;
                $this->view->producto = $producto;
                $this->view->render('productos/nuevo');

                die();
            }
        }

        //Verifiva que la referencia no exista
        if ($this->model->existReference($referencia) > 0) {
            $mensaje = "Esta refencia ya ha sido registrada anteriormente";
            $this->view->mensaje = $mensaje;
            $this->view->render('productos/nuevo');
        } else {
            if ($this->model->insert(['referencia' => $referencia, 'descripcion' => $descripcion, 'foto' => $ruta])) {
                $mensaje = "Producto registrado correctamente";
                $route = "public/" . $ruta;
                move_uploaded_file($foto, $route);
                $this->view->mensaje = $mensaje;
                $this->render();
            } else {
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
        $producto = ['id' => $id, 'referencia' => $referencia, 'descripcion' => $descripcion];

        $fotoName = $_FILES['foto']['name'];
        $foto = $_FILES['foto']['tmp_name'];
        $newFotoName = $this->createName() . "-" . $referencia . ".jpg";

        $productoAct = $this->model->getById($id);

        if (empty($_FILES['foto']['name'])) {
            $ruta = $productoAct['foto'];
        } else {
            $permitidos = array("image/jpg", "image/png", "image/jpeg");
            // echo $_FILES['foto']['type'];
            if (in_array($_FILES['foto']["type"], $permitidos)) {
                $ruta = 'fotos';
                $ruta =  $ruta . "/" . $newFotoName;
            } else {
                $mensaje = "El formato de la foto es incorrecto";
                $this->view->mensaje = $mensaje;
                $this->view->producto = $producto;
                $this->view->render('productos/nuevo');
                die();
            }
        }

        //Verifica que la referencia no cambio
        if (strtoupper($productoAct['codigo']) == strtoupper($referencia)) {
            if ($this->model->update(['id' => $id, 'codigo' => $referencia, 'descripcion' => $descripcion, 'foto' => $ruta])) {
                $registrada = true;
                $route = "public/" . $ruta;
                    if (!empty($_FILES['foto']['name'])) {
                        move_uploaded_file($foto, $route);
                    
                        if(!is_null($productoAct['foto'])){
                            unlink("public/" . $productoAct['foto']);
                         
                        }
                        
                    }
                    
            } else {
                $this->view->mensaje = "Error al actualizar el producto";
                $producto = ['id' => $id, 'referencia' => $referencia, 'descripcion' => $descripcion];
            }
        } else {
            // Si la referencia cambio, verifica que la nueva no haya sido registrada
            if ($this->model->existReference($referencia) > 0) {
                $this->view->mensaje = "La referencia ya se encuentra registrada";
            } else {
                if ($this->model->update(['id' => $id, 'codigo' => $referencia, 'descripcion' => $descripcion, 'foto' => $ruta])) {
                    $registrada = true;
                    $route = "public/" . $ruta;
                    if (!empty($_FILES['foto']['name'])) {
                        move_uploaded_file($foto, $route);
                            unlink("public/" . $productoAct['foto']);
                    }
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
