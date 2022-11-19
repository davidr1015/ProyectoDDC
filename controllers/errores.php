<?php

class Errores extends Controller{

    function __construct(){
        parent::__construct();
        $this->view->mensaje = "No existe la pagina";
        $this->view->render('errores/index');
    
    }
}
?>