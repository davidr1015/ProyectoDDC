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
        $this->view->render('inventario/nuevo');
    }



    public function buscarPorCodigo()
    {
        // if (isset($_POST['buscar'])) {
        $referencia = $_POST['referencia'];
        // $referencia = 'P0212';
        $valores = array();
        $valores['existe'] = "0";


        $producto = $this->model->getByReference($referencia);

        // echo "Producto <br>";
        //        var_dump($producto);
        if ($producto) {

            $id_producto = $producto['id_producto'];
            $id_bodega = $this->model->getBodegas($id_producto);

            $bg = [];


            foreach ($id_bodega as $bodega) {
                array_push($bg, $bodega);
            }
            $producto['bodegas'] = $bg;
            $valores['existe'] = "1";
            $valores['id'] = $producto['id_producto'];
            $valores['descripcion'] = $producto['descripcion'];
            $valores['kgdisp'] = $producto['sumKilos'];
            $valores['btdisp'] = $producto['sumBultos'];
            $valores['bodegas'] = $producto['bodegas'];
        }

        $valores = json_encode($valores);
        echo $valores;
        // } 
    }

    public function listarLotes()
    {
        if (isset($_POST['buscar'])) {

            $id_producto = $_POST['id'];
            $id_bodega = $_POST['bodega'];


            $valores = array();
            $valores['existe'] = "0";

            $valores['lotes'] = [];

            $lotes = $this->model->getLotes(['idProducto' => $id_producto, 'idBodega' => $id_bodega]);

            $valores['existe'] = "1";
            foreach ($lotes as $lote) {

                $valor['lote'] = $lote["lote"];
                $valor['kgdisp'] = $lote['kilos'];
                $valor['btdisp'] = $lote['bultos'];

                array_push($valores['lotes'], $valor);
            }


            $valores = json_encode($valores);
            echo $valores;
        }
    }



    public function infoLotes()
    {
        if (isset($_POST['buscar'])) {

            // $id_producto = "1";
            // $id_bodega = "1";
            // $lote = "1";

            $id_producto = $_POST['id'];
            $id_bodega = $_POST['bodega'];
            $lote = $_POST['lote'];


            $valores = array();
            $valores['existe'] = "0";

            $lotes = $this->model->getInfoLotes(['idProducto' => $id_producto, 'idBodega' => $id_bodega, 'lote' => $lote]);

            // var_dump($lotes);

            $valores['existe'] = "1";


            $valores['lote'] = $lotes["lote"];
            $valores['kgdisp'] = $lotes['kilos'];
            $valores['btdisp'] = $lotes['bultos'];

            $valores = json_encode($valores);
            echo $valores;
        }
    }

    function registrarEgreso()
    {
        $this->view->titulo = "Sacar Producto de inventario";
        $mensaje = "";

        if (isset($_POST['referencia'])) {
            $id  = $_POST['id_producto'];
            $referencia  = strtoupper($_POST['referencia']);
            $descripcion = $_POST['descripcion-h'];
            $bodega = $_POST['bodega'];
            $lote = $_POST['lote'];
            $kgDisp = $_POST['kg-disp-2-h'];
            $btDisp = $_POST['bt-disp-2-h'];
            $kgSacar = $_POST['kg-sacar'];
            $btSacar = $_POST['bt-sacar'];

            $producto = ['referencia' => $referencia];

            if ($kgSacar > $kgDisp || $btSacar > $btDisp) {
                $mensaje = "El numero de kilos o bultos que deseas retirar es mayor a los disponibles";
    
                $this->view->mensaje = $mensaje;
                $this->view->producto = $producto;
                $this->view->render("inventario/nuevo");
                die();
            } else {
                $insertar = $this->model->actualizarInventario(['id_producto' => $id, 'id_bodega' => $bodega, 'lote' => $lote, 'kilos' => $kgSacar, 'bultos' => $btSacar]);
                if ($insertar) {

                    
                    $this->render();
                }
            }
        }else {
            $this->render();
        }

       
    }
}
