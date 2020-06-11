<?php

class Grupo {

    var $id;
    var $nombre;
    var $id_campeonato;
    var $id_categoria;

    
    function __construct($id, $nombre, $id_campeonato, $id_categoria){
        $this->id = $id;
        $this->nombre= $nombre;
        $this->id_campeonato = $id_campeonato;
        $this->id_categoria = $id_categoria;

    } 
    
    function getId(){
        return $this->id;
    }

    function setId($id){
        $this->id = $id;
    }

    function getNombre(){
        return $this->nombre;
    }

    function setNombre($nombre){
        $this->nombre = $nombre;
    }

    function getId_campeonato()
    {
        return $this->id_campeonato;
    }

    function setId_campeonato($id_campeonato)
    {
        $this->id_campeonato = $id_campeonato;
    }

    function getId_categoria()
    {
        return $this->id_categoria;
    }

    function setId_categoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;
    }

    function check() {
        $error = false;

        if (strlen($this->nombre) < 2) {
            $error = true;
        }

        if (strlen($this->id_campeonato) < 2) {
            $error = true;
        }
        
        if (strlen($this->id_categoria) < 2) {
            $error = true;
        }

        return $error;
    }

}

?>