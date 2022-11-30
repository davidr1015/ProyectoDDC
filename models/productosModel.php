<?php

class ProductosModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get(){
        
        $items = [];

        try {
            $query = $this->db->connect()->query("SELECT * FROM productos WHERE activo = 1");

            while ($row = $query->fetch()) {

                array_push($items, $row);
            }
            return $items;
        } catch (PDOException $e) {
            return [];
        }          
    }

    public function insert($datos) {
        $codigo = $datos['referencia'];
        $descripcion = $datos['descripcion'];
        $foto = $datos['foto'];
            try {
                $query = $this->db->connect()->prepare('INSERT INTO productos (codigo, descripcion, foto, activo) VALUES (:codigo, :descripcion, :foto, 1)');
                $query->execute(['codigo' => $codigo, 'descripcion' => $descripcion, 'foto'=> $foto]);
                return true;
            } catch (PDOException $e) {
                return false;
            }
        
    }
    

    public function existReference($referencia) {
        $query = $this->db->connect()->prepare("SELECT * FROM productos WHERE codigo = :codigo and activo = 1");
        try {
            $query->execute(['codigo' => $referencia]);
            $count = $query->rowCount();
            return $count;

        } catch (PDOException $e) {
            return 0;         
        }
    }

    public function getById($id) {
        $query = $this->db->connect()->prepare("SELECT * FROM productos WHERE id = :id");
        try {
            $query->execute(['id' => $id]);
            $item = $query->fetch(); 

            return $item;
        } catch (PDOException $e) {
            return [];          
        }
    }

    public function update($item) {
        $query = $this->db->connect()->prepare("UPDATE productos SET codigo = :codigo, descripcion = :descripcion, foto = :foto WHERE id = :id");

        try {
            $query->execute([
                'id' => $item['id'],
                'codigo' => $item['codigo'],
                'descripcion' => $item['descripcion'],
                'foto' => $item['foto']
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        $query = $this->db->connect()->prepare("UPDATE productos SET activo = 0 WHERE id = :id");

        try {
            $query->execute([
                'id' => $id
            ]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // public function delete($id) {
    //     $query = $this->db->connect()->prepare("DELETE from alumnos WHERE matricula = :id");

    //     try {
    //         $query->execute([
    //             'id' => $id,
    //         ]);
    //         return true;
    //     } catch (PDOException $e) {
    //         return false;
    //     }
    // }
    
}
