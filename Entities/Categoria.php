<?php

class Categoria {

    var $id;
    var $nivel;
    var $genero;

    
    function __construct($id, $nivel, $genero){
        $this->id = $id;
        $this->nivel= $nivel;
        $this->genero = $genero;

    } 
    
    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getNivel(){
        return $this->nivel;
    }

    function setNivel($nivel){
        $this->nivel = $nivel;
    }

    function getGenero()
    {
        return $this->genero;
    }


    function setGenero($genero)
    {
        $this->genero = $genero;
    }

    function check() {
        $error = false;

        if (strlen($this->nivel) < 2) {
            $error = true;
        }

        if (strlen($this->genero) < 2) {
            $error = true;
        }

        return $error;
    }

}

?>