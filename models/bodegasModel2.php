<?php

class BodegasModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get(){
        $items = [];

       
            $query = $this->db->connect()->query("SELECT * FROM bodegas");

           if($query) {
            while ($row = $query->fetch_array()) {

                array_push($items, $row);
            }
            return $items;
           }else{
            return [];
           }
            

                  
    }

    // public function getById($id) {
    //     $item = new Alumno();
    //     $query = $this->db->connect()->prepare("SELECT * FROM alumnos WHERE matricula = :matricula");
    //     try {
    //         $query->execute(['matricula' => $id]);

    //         while ($row = $query->fetch()) {
    //             $item->matricula = $row['matricula'];
    //             $item->nombre = $row['nombre'];
    //             $item->apellido = $row['apellido'];
    //         }

    //         return $item;
    //     } catch (PDOException $e) {
    //         return [];          
    //     }
    // }

    // public function update($item) {
    //     $query = $this->db->connect()->prepare("UPDATE alumnos SET nombre = :nombre, apellido = :apellido WHERE matricula = :matricula");

    //     try {
    //         $query->execute([
    //             'matricula' => $item['matricula'],
    //             'nombre' => $item['nombre'],
    //             'apellido' => $item['apellido']
    //         ]);
    //         return true;
    //     } catch (PDOException $e) {
    //         return false;
    //     }
    // }

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
