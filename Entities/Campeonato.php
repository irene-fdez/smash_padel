<?php

class Campeonato {

    var $id;
    var $nombre;
    var $fecha;
    var $login_admin;

    
    function __construct($id, $nombre, $fecha, $login_admin){
        $this->id = $id;
        $this->nombre= $nombre;
        $this->fecha = $fecha;
        $this->login_admin = $login_admin;

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

    function getFecha()
    {
        return $this->fecha;
    }

    function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    function getLoginAdmin()
    {
        return $this->login_admin;
    }

    function setLoginAdmin($login_admin)
    {
        $this->login_admin = $login_admin;
    }

    function check() {
        $error = false;

        if (strlen($this->nombre) < 2) {
            $error = true;
        }

        return $error;
    }

}

?>