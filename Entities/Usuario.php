<?php

class Usuario {

    var $login;
    var $password; 
	var $nombre;
    var $apellidos;
    var $genero;
    var $email;
    var $rol;


    function __construct($login, $password, $nombre, $apellidos, $genero, $email, $rol){
        $this->login = $login;
        if( $password != NULL){
            $this->password = md5($password);
        }
		$this->nombre = $nombre;
		$this->apellidos = $apellidos;
		$this->genero = $genero;
        $this->email = $email;
        $this->rol = $rol;

    } 
    
    function getLogin(){
        return $this->login;
    }

    function setLogin($login){
        $this->login = $login;
    }
   
    function getPassword(){
        return $this->password;
    }

    function setPassword($password){
        $this->password = $password;
    }

    public function getNombre(){
        return $this->nombre;
    }


    public function setNombre($nombre){
        $this->nombre = $nombre;
    }


    public function getApellidos(){
        return $this->apellidos;
    }


    public function setApellidos($apellidos){
        $this->apellidos = $apellidos;
    }

    function getGenero(){
        return $this->genero;
    }

    function setGenero($genero){
        $this->genero = $genero;
    }
 
    function getEmail(){
        return $this->email;
    }

    function setEmail($email){
        $this->email = $email;
    }

    function getRol(){
        return $this->rol;
    }

    function setRol($rol){
        $this->rol = $rol;
    }

    

    function checkLogin() {

        $error = false;

        if (strlen($this->login) < 2) {
            $error = true;
        }

        if (strlen($this->password) < 2) {
            $error = true;
        }
        
        return $error;
    }

    function check() {
        $error = false;

        if (strlen($this->login) < 2) {
            $error = true;
        }

        if (strlen($this->password) < 2) {
            $error = true;
        }

        if (strlen($this->nombre) < 2) {
            $error = true;
        }
        
        if (strlen($this->apellidos) < 2) {
            $error = true;
        }

        if (strlen($this->genero) < 2) {
            $error = true;
        }

        if (strlen($this->email) < 2) {
            $error = true;
        }

      /*  if (strlen($this->rol) < 2) {
            $error = true;
        }*/

        return $error;
    }

    function checkEdit() {
        $error = false;

        if (strlen($this->login) < 2) {
            $error = true;
        }
       /* if (strlen($this->password) < 2) {
            if($this->password != NULL){
                $error = true;
            }
        }*/

        if (strlen($this->nombre) < 2) {
            $error = true;
        }
        
        if (strlen($this->apellidos) < 2) {
            $error = true;
        }

        if (strlen($this->genero) < 2) {
            $error = true;
        }

        if (strlen($this->email) < 2) {
            $error = true;
        }

      /*  if (strlen($this->rol) < 2) {
            $error = true;
        }*/

        return $error;
    }


}

?>