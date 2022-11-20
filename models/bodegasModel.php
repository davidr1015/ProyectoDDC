<?php

class BodegasModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get(){
        
        $items = [];

        try {
            $query = $this->db->connect()->query("SELECT * FROM bodegas WHERE activo = 1");

            while ($row = $query->fetch()) {

                array_push($items, $row);
            }
            return $items;
        } catch (PDOException $e) {
            return [];
        }          
    }

    public function insert($datos) {
        $nombre = $datos['nombre'];
        $numLotes = $datos['numLotes'];
        
            try {
                $query = $this->db->connect()->prepare('INSERT INTO bodegas (nombre, num_lotes, activo) VALUES (:nombre, :numLotes,1)');
                $query->execute(['nombre' => $nombre, 'numLotes' => $numLotes]);
                return true;
            } catch (PDOException $e) {
                return false;
            }
        
    }
    

    public function getById($id) {
        $query = $this->db->connect()->prepare("SELECT * FROM bodegas WHERE id = :id");
        try {
            $query->execute(['id' => $id]);
            $item = $query->fetch(); 

            return $item;
        } catch (PDOException $e) {
            return [];          
        }
    }

    public function update($item) {
        $query = $this->db->connect()->prepare("UPDATE bodegas SET nombre = :nombre, num_lotes = :num_lotes WHERE id = :id");

        try {
            $query->execute([
                'id' => $item['id'],
                'nombre' => $item['nombre'],
                'num_lotes' => $item['numLotes']
            ]);
            
            return true;
        } catch (PDOException $e) {
            
            return false;
        }
    }

    public function delete($id) {
        $query = $this->db->connect()->prepare("UPDATE bodegas SET activo = 0 WHERE id = :id");

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
