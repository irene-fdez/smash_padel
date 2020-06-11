<?php

class Inscripcion {

    var $id;
    var $fecha;
    var $id_pareja;
    var $id_cat_camp;
    var $id_grupo;

    
    function __construct($id, $fecha, $id_pareja, $id_cat_camp, $id_grupo){
        $this->id = $id;
        $this->fecha= $fecha;
        $this->id_pareja = $id_pareja;
        $this->id_cat_camp = $id_cat_camp;
        $this->id_grupo = $id_grupo;

    } 
    
    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getFecha(){
        return $this->fecha;
    }

    function setFecha($fecha){
        $this->fecha = $fecha;
    }

    function getId_pareja()
    {
        return $this->id_pareja;
    }

    function setId_pareja($id_pareja){
        $this->id_pareja = $id_pareja;
    }

    function getId_cat_camp(){
        return $this->id_cat_camp;
    }

    function setId_cat_camp($id_cat_camp){
        $this->id_cat_camp = $id_cat_camp;
    }

    function getId_grupo(){
        return $this->id_grupo;
    }

    function setId_grupo($id_grupo){
        $this->id_grupo = $id_grupo;
    }

  /*  function check() {
        $error = false;

        if (strlen($this->fecha) < 2) {
            $error = true;
        }

        if (strlen($this->id_pareja) < 2) {
            $error = true;
        }
        
        if (strlen($this->id_categoria) < 2) {
            $error = true;
        }

        return $error;
    }*/

}

?>