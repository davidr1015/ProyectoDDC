<?php

class Movimientos extends Controller
{

    function __construct()
    {
        parent::__construct();
        $this->view->productos = [];
        $this->view->mensaje = "";
    }


    function render()
    {
        $movimientos = $this->model->listarMovimientos();

        $this->view->movimientos = $movimientos;
        $this->view->titulo = "Entradas y Salidas";
        $this->view->render('movimientos/index');
    }


    function entrada()
    {
        $this->view->titulo = "Ingresar Producto";
        $this->view->render('movimientos/entrada');
    }

    function salida()
    {
        $this->view->titulo = "Retirar Producto";
        $this->view->render('movimientos/salida');
    }


    public function buscarPorCodigo()
    {
        if (isset($_POST['buscar'])) {
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
        }
    }


    public function buscarTodoPorCodigo()
    {
        if (isset($_POST['buscar'])) {
            $referencia = $_POST['referencia'];
            // $referencia = 'P01';
            $valores = array();
            $valores['existe'] = "0";


            $producto = $this->model->getByReferenceAll($referencia);


            if ($producto) {

                $id_producto = $producto['id'];
                $id_bodega = $this->model->getBodegasIngreso($id_producto);
                // var_dump($id_bodega);
                // echo "<br><br>";
                $bg = [];


                foreach ($id_bodega as $bodega) {
                    array_push($bg, $bodega);
                }
                $producto['bodegas'] = $bg;
                $valores['existe'] = "1";
                $valores['id'] = $producto['id'];
                $valores['descripcion'] = $producto['descripcion'];
                // $valores['kgdisp'] = $producto['sumKilos'];
                // $valores['btdisp'] = $producto['sumBultos'];
                $valores['bodegas'] = $producto['bodegas'];
            }

            $valores = json_encode($valores);
            echo $valores;
        }
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

    public function listarLotesIngreso()
    {
        if (isset($_POST['buscar'])) {

            $id_producto = $_POST['id'];
            $id_bodega = $_POST['bodega'];
            // $id_producto = "1";
            // $id_bodega = "1";

            $valores = array();
            $listaLotes = array();
            $valores['lotes'] = [];
            $listaLotes['lotes'] = [];

            $valores['existe'] = "0";

            $bodega = $this->model->getbodega($id_bodega);
            $lotes = $this->model->getLotesIngreso(['idProducto' => $id_producto, 'idBodega' => $id_bodega]);

            $valores['existe'] = "1";
            foreach ($lotes as $lote) {
                $valor['lote'] = $lote["lote"];
                array_push($listaLotes['lotes'], $valor['lote']);
            }

            for ($i = 1; $i <= $bodega[0]['num_lotes']; $i++) {
                if (!in_array($i, $listaLotes['lotes'])) {
                    $valor['lote'] = $i;
                    array_push($valores['lotes'], $valor);
                }
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


            if ($lotes) {
                $valores['lote'] = $lotes["lote"];
                $valores['kgdisp'] = $lotes['kilos'];
                $valores['btdisp'] = $lotes['bultos'];
            } else {
                $valores['kgdisp'] = 0;
                $valores['btdisp'] = 0;
            }

            $valores = json_encode($valores);
            echo $valores;
        }
    }

    function registrarEgreso()
    {

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
                $this->view->render("movimientos/salida");
                die();
            } else {
                $insertar = $this->model->actualizarInventario(['id_producto' => $id, 'id_bodega' => $bodega, 'lote' => $lote, 'kilos' => ($kgSacar * -1), 'bultos' => ($btSacar * -1)]);
                if ($insertar) {
                    $actualizar = $this->model->registrarMovimiento(
                        [
                            'id' => $id,
                            'referencia' => $referencia,
                            'descripcion' => $descripcion,
                            'id_bodega' => $bodega,
                            'lote' => $lote,
                            'kilos' => $kgSacar,
                            'bultos' => $btSacar,
                            'tipo' => "Retiro"
                        ]
                    );


                    $this->render();
                }
            }
        } else {
            $this->render();
        }
    }

    function registrarIngreso()
    {

        $mensaje = "";

        if (isset($_POST['referencia'])) {
            $id  = $_POST['id_producto'];
            $referencia  = strtoupper($_POST['referencia']);
            $descripcion = $_POST['descripcion-h'];
            $bodega = $_POST['bodega'];
            $lote = $_POST['lote'];
            // $kgDisp = $_POST['kg-disp-2-h'];
            // $btDisp = $_POST['bt-disp-2-h'];
            $kgIngresar = $_POST['kg-ingresar'];
            $btIngresar = $_POST['bt-ingresar'];

            $producto = ['referencia' => $referencia];

            $lotes = $this->model->getInfoLotes(['idProducto' => $id, 'idBodega' => $bodega, 'lote' => $lote]);

            if($lotes){
                $actualizar = $this->model->actualizarInventario(['id_producto' => $id, 'id_bodega' => $bodega, 'lote' => $lote, 'kilos' => $kgIngresar, 'bultos' => $btIngresar]);
                echo "existe";
            }else {
                $insertar = $this->model->ingresarAInventario(['id_producto' => $id, 'id_bodega' => $bodega, 'lote' => $lote, 'kilos' => $kgIngresar, 'bultos' => $btIngresar]);
                echo "no existe";
            }

          
            if ($insertar || $actualizar) {
                $actualizar = $this->model->registrarMovimiento(
                    [
                        'id' => $id,
                        'referencia' => $referencia,
                        'descripcion' => $descripcion,
                        'id_bodega' => $bodega,
                        'lote' => $lote,
                        'kilos' => $kgIngresar,
                        'bultos' => $btIngresar,
                        'tipo' => "Ingreso"
                    ]
                );


                $this->render();
            }
        } else {
            $this->render();
        }
    }
}

// 
