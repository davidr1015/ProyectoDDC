<?php

class Bodegas extends Controller {

    function __construct()
    {
        parent::__construct();
        // echo "<p>Nuevo controlador Main</p>";
        $this->view->bodegas = [];
    }

    function render(){
        $bodegas = $this->model->get();
        $this->view->bodegas = $bodegas;
        $this->view->titulo = "Bodegas";
        $this->view->render('bodegas/index');
    }

    function nuevo(){
        $this->view->render('bodegas/nuevo');
    }

    function eliminados() {
        $bodegas = $this->model->get();
        $this->view->bodegas = $bodegas;
        $this->view->render('bodegas/eliminados');
    }

    
}
?>