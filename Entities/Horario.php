<?php

class Horario {

    var $id;
    var $hora_inicio;
    var $hora_fin;

    
    function __construct($id, $hora_inicio, $hora_fin){
        $this->id = $id;
        $this->hora_inicio= $hora_inicio;
        $this->hora_fin = $hora_fin;

    } 
    
    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getHora_inicio(){
        return $this->hora_inicio;
    }

    function setHora_inicio($hora_inicio){
        $this->hora_inicio = $hora_inicio;
    }

    function getHora_fin()
    {
        return $this->hora_fin;
    }


    function setHora_fin($hora_fin)
    {
        $this->hora_fin = $hora_fin;
    }

}

?>