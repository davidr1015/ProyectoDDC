<?php

class InventarioModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts()
    {

        $items = [];

        try {
            $query = $this->db->connect()->query("SELECT DISTINCT id_producto, codigo, descripcion, sum(kilos) as sumKilos, sum(bultos) as sumBultos, foto 
            FROM producto_bodega INNER JOIN productos on id_producto = productos.id
            GROUP BY(id_producto)");

            while ($row = $query->fetch()) {

                array_push($items, $row);
            }
            return $items;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getBodegas($id){

        $items = [];

        $query = $this->db->connect()->prepare("SELECT DISTINCT id_bodega, nombre, sum(kilos) AS sumKilos, sum(bultos) AS sumBultos
        FROM producto_bodega INNER JOIN bodegas ON id_bodega = bodegas.id
        WHERE id_producto = :id
        GROUP BY(id_bodega)");

        try {
            $query->execute(['id' => $id]);

            while ($row = $query->fetch()) {

                array_push($items, $row);
            }

            return $items;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getLotes($data){
        $items = [];
        
        $idProducto = $data['idProducto'];
        $idBodega = $data['idBodega'];

        $query = $this->db->connect()->prepare("SELECT lote, kilos, bultos FROM producto_bodega WHERE id_producto = :idProducto AND id_bodega = :idBodega");

        try {
            $query->execute(['idProducto' => $idProducto, 'idBodega' => $idBodega]);

            while ($row = $query->fetch()) {
                array_push($items, $row);
            }

            return $items;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getInfoLotes($data){
        $items = [];
        
        $idProducto = $data['idProducto'];
        $idBodega = $data['idBodega'];
        $lote = $data['lote'];

        $query = $this->db->connect()->prepare("SELECT lote, kilos, bultos FROM producto_bodega WHERE id_producto = :idProducto AND id_bodega = :idBodega AND lote = :lote");

        try {
            $query->execute(['idProducto' => $idProducto, 'idBodega' => $idBodega, 'lote' => $lote]);

            $items = $query->fetch();
             

            return $items;
        } catch (PDOException $e) {
            return [];
        }
    }




    public function insert($datos)
    {
        $codigo = $datos['referencia'];
        $descripcion = $datos['descripcion'];

        try {
            $query = $this->db->connect()->prepare('INSERT INTO productos (codigo, descripcion, activo) VALUES (:codigo, :descripcion,1)');
            $query->execute(['codigo' => $codigo, 'descripcion' => $descripcion]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function existReference($referencia)
    {
        $query = $this->db->connect()->prepare("SELECT * FROM productos WHERE codigo = :codigo and activo = 1");
        try {
            $query->execute(['codigo' => $referencia]);
            $count = $query->rowCount();
            return $count;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getById($id)
    {
        $query = $this->db->connect()->prepare("SELECT DISTINCT id_producto, codigo, descripcion, sum(kilos) as sumKilos, sum(bultos) as sumBultos, foto 
        FROM producto_bodega INNER JOIN productos on id_producto = productos.id
        WHERE id_producto = :id GROUP BY(id_producto)");
        try {
            $query->execute(['id' => $id]);

            $item = $query->fetch();


            return $item;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getByReference($id)
    {
        $query = $this->db->connect()->prepare("SELECT DISTINCT id_producto, codigo, descripcion, sum(kilos) as sumKilos, sum(bultos) as sumBultos, foto 
        FROM producto_bodega INNER JOIN productos on id_producto = productos.id
        WHERE codigo = :id  and activo = 1 GROUP BY(id_producto)");
        try {
            $query->execute(['id' => $id]);

            $item = $query->fetch();


            return $item;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function actualizarInventario($datos)
    {
        $id_producto = $datos['id_producto'];
        $id_bodega = $datos['id_bodega'];
        $lote = $datos['lote'];
        $kilos = $datos['kilos'];
        $bultos = $datos['bultos'];

        try {
            $query = $this->db->connect()->prepare('UPDATE producto_bodega SET kilos = (kilos - :kilos), bultos = (bultos- :bultos) WHERE id_producto = :id_producto AND id_bodega = :id_bodega AND lote = :lote');
            $query->execute(['kilos' => $kilos, 'bultos' => $bultos, 'id_producto' => $id_producto, 'id_bodega' => $id_bodega, 'lote' => $lote]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function registrarMovimiento($datos)
    {
        $id = $datos['id'];
        $referencia = $datos['referencia'];
        $descripcion = $datos['descripcion'];
        $id_bodega = $datos['id_bodega'];
        $lote = $datos['lote'];
        $kilos = $datos['kilos'];
        $bultos = $datos['bultos'];
        $tipo = $datos['tipo'];
        

        try {
            $query = $this->db->connect()->prepare('INSERT INTO movimientos (id, id_producto, referencia, descripcion, id_bodega, lote, kilos, bultos, tipo) VALUES (:id, :referencia, :descripcion, :id_bodega, :lote, :kilos, :bultos:, tipo)');
            $query->execute([
                'id' => $id, 
                'referencia' => $referencia,
                'descripcion' => $descripcion, 
                'id_bodega' => $id_bodega, 
                'lote' => $lote, 
                'kilos' => $kilos, 
                'bultos' => $bultos, 
                'tipo' => $tipo]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

   

}
