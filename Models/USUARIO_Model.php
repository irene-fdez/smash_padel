<?php

class USUARIO_Model
{

    var $login;
    var $password;
    var $nombre;
    var $apellidos;
    var $genero;
    var $email;
    var $respuesta;

    var $mysqli;


    function __construct($user)
    {

        $this->user = $user;

        include '../Models/DB/BdAdmin.php';
        $this->mysqli = ConnectDB();

    }


    /*Function to get user data from login*/
    function getDataByLogin()
    {
        $login = $this->user->getLogin();

        $sql = "SELECT * FROM USUARIO WHERE login = '$login'";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            $result = $resultado->fetch_array();
            return $result;
        }
    }

    /*Function to get user data from email*/
    function getData()
    {
        $login = $this->user->getLogin();

        $sql = "SELECT U.login, U.nombre, U.apellidos, U.genero, U.email, R.nombre as 'rol' FROM USUARIO U, ROL R WHERE U.ROL_id = R.id AND login = '$login'";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            $result = $resultado->fetch_array();
            return $result;
        }
    }

  /*  function getDataPassword()
    {
        $dni = $this->user->getDni();

        $sql = "SELECT email,usuario.dni,usuario.nombre,usuario.apellidos, usuario.borrado, usuario.password, rol.nombre as rol FROM `usuario`INNER JOIN `usuario_rol` 
            ON usuario_rol.id_USUARIO=usuario.dni INNER JOIN `rol` ON usuario_rol.id_ROL=rol.id WHERE dni = '$dni'";
            
        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            $result = $resultado->fetch_array();
            return $result;
        }
    }*/

    function getDataRoleUser()
    {
        $login = $this->user->getLogin();

        $sql = "SELECT ROL_id FROM USUARIO WHERE login = '$login'";

        $resultado = $this->mysqli->query($sql);

        return $resultado;

    }

    function getDataRoleNameUser()
    {
        $login = $this->user->getLogin();

        $sql = "SELECT R.* FROM USUARIO U, ROL R WHERE R.id = U.ROL_id AND U.login = '$login'";

        /*$sql = "SELECT * FROM USUARIO INNER JOIN `usuario_rol` 
            ON usuario_rol.id_USUARIO = usuario.dni INNER JOIN `rol` ON rol.id = usuario_rol.id_ROL WHERE usuario.email = '$login'";*/

        $resultado = $this->mysqli->query($sql);

        return $resultado;

    }
/*
    function getDNIbyEmail()
    {
        $email = $this->user->getEmail();

        $sql = "SELECT usuario.dni FROM `usuario` WHERE email = '$email'";

        $resultado = $this->mysqli->query($sql);
        $result = $resultado->fetch_array();

        return $result['dni'];
    }*/

    function AllData()
    {

        $sql = "SELECT U.login, U.nombre, U.apellidos, U.genero, U.email, R.nombre as 'rol' FROM USUARIO U, ROL R WHERE U.ROL_id = R.id ";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }
    }

    function AllLogins(){
        $sql = "SELECT U.login FROM USUARIO U, ROL R WHERE U.ROL_id = R.id AND R.nombre = 'Deportista'";

        if (!($resultado = $this->mysqli->query($sql))) {
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            if ($resultado->num_rows == 0) {
                return 0;
            }else{
                return $resultado;
            }
        }
    }

    function Add()
    {
        $login = $this->user->getLogin();
        $password = $this->user->getPassword();
        $nombre = $this->user->getNombre();
        $apellidos = $this->user->getApellidos();
        $genero = $this->user->getGenero();
        $email = $this->user->getEmail();
        $rol = $this->user->getRol();

        if (($login <> '')) {

            $sql = "SELECT * FROM USUARIO WHERE login = '$login'";
         
            if (!$result = $this->mysqli->query($sql)) {
              
                $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
                $this->respuesta["type"]=false;
                return $this->respuesta;
            } else {
            
                if ($result->num_rows == 0) 
                {
                    $sql = "SELECT * FROM USUARIO  WHERE email = '$email'";
                    
                    if (!$result = $this->mysqli->query($sql)) {
                    
                        $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
                        $this->respuesta["type"]=false;
                        return $this->respuesta;
                    } else {
                        if ($result->num_rows == 0) {
                            $sql = "INSERT INTO USUARIO (login, password, nombre, apellidos, genero, email, ROL_id) 
                                                VALUES ('$login', '$password', '$nombre', '$apellidos', '$genero', '$email', '$rol');";

                            if (!$this->mysqli->query($sql)) {
                                $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
                                $this->respuesta["type"]=false;
                                return $this->respuesta;
                            }else{ 
                                $this->respuesta["text"]='Insertado correctamente';
                                $this->respuesta["type"]=true;
                                return $this->respuesta;
                            }
                        }else{
                            $this->respuesta["text"]='El email ' . $email . ' ya existe en la Base de Datos';
                            $this->respuesta["type"]=false;
                            return $this->respuesta;
                        }
                    }
                } else {
                    $this->respuesta["text"]='El login ' . $login . ' ya existe en la Base de Datos';
                    $this->respuesta["type"]=false;
                    return $this->respuesta;
                }
            }
        } else {
            $this->respuesta["text"]='Introduce un valor';
            $this->respuesta["type"]=false;
            return $this->respuesta;
            }

    }


    function delete()
    {
        $login = $this->user->getLogin();

        $sql = "SELECT * FROM USUARIO WHERE (login = '$login')";

        $result = $this->mysqli->query($sql);

        if ($result->num_rows == 1) {

            $sql2 = "DELETE FROM USUARIO WHERE (login = '$login')";

            if ($this->mysqli->query($sql2)) {
                $this->respuesta["text"]='Eliminado correctamente';
                $this->respuesta["type"]=true;
                return $this->respuesta;
            }else{
                $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
                $this->respuesta["type"]=false;
                return $this->respuesta;
            }
        } else{
            $this->respuesta["text"]='El DNI ' . $login . ' no existe en la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }
    }


  /*  function deleteUserRoles()
    {

        $dni = $this->user->getDLogin();

        $sql = "DELETE FROM `usuario_rol` WHERE id_USUARIO = '$dni'";

        if(!$this->mysqli->query($sql)){
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }else{
            return true;
        }
    }*/

    function Edit()
    {

        $login = $this->user->getLogin();
        $password = $this->user->getPassword();
        $nombre = $this->user->getNombre();
        $apellidos = $this->user->getApellidos();
        $email = $this->user->getEmail();
        $genero = $this->user->getGenero();
        $rol = $this->user->getRol();

        $sql = "SELECT * FROM USUARIO WHERE (login = '$login')";
        $result = $this->mysqli->query($sql);

        if ($result->num_rows == 1) {
            $sql = "SELECT * FROM USUARIO WHERE email = '$email' AND (login <> '$login')";

            $result = $this->mysqli->query($sql);
            if ($result->num_rows == 0) {
                if($password != NULL){

                    $sql2 = "UPDATE USUARIO SET 
                                                password = '$password',
                                                nombre = '$nombre',
                                                apellidos = '$apellidos',
                                                genero = '$genero',
                                                email = '$email',
                                                ROL_id = '$rol'
                                            WHERE ( login = '$login')";  
                }else{
                    $sql2 = "UPDATE USUARIO SET
                                                nombre = '$nombre',
                                                apellidos = '$apellidos',
                                                genero = '$genero',
                                                email = '$email',
                                                ROL_id = '$rol'
                                            WHERE ( login = '$login')";  
                }
                if (!($resultado = $this->mysqli->query($sql2))) {
                    $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
                    $this->respuesta["type"]=false;
                    return $this->respuesta;
                } else {
                    $this->respuesta["text"]='Editado correctamente';
                    $this->respuesta["type"]=true;
                    return $this->respuesta;
                }
            }else{
                $this->respuesta["text"]='El email ' . $email . ' ya existe en la Base de Datos';
                $this->respuesta["type"]=false;
                return $this->respuesta;
            }
        } else
            $this->respuesta["text"]='El DNI ' . $login . ' no existe en la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
    }

    function setUserRole($id_ROL)
    {
        $dni=$this->user->getDni();
        $sql = "INSERT INTO `usuario_rol` (`id_USUARIO`, `id_ROL`) VALUES ('$dni', '$id_ROL')";
        if ($this->mysqli->query($sql)) {
            $this->respuesta["text"]='Se ha asignado un rol correctamente';
            $this->respuesta["type"]=true;
            return $this->respuesta;
        }else{
            $this->respuesta["text"]='No se ha podido acceder a la Base de Datos';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        }

    }

  /*  function getLastAnhoAcademico(){
        $sql = "SELECT MAX(id) as id FROM `anhoacademico` WHERE (borrado = 0)";

        $resultado = $this->mysqli->query($sql);

        return $resultado;
    }*/


    function login()
    {

        $email = $this->user->getEmail();
        
        $sql = "SELECT *
				FROM `usuario`
				WHERE email = '$email'";

        $resultado = $this->mysqli->query($sql);
        
        if ($resultado->num_rows == 0) {
            $this->respuesta["text"]='El email' . $email .' no existe en la BD';
            $this->respuesta["type"]=false;
            return $this->respuesta;
        } else {
            $tupla = $resultado->fetch_array();
            
            if ($tupla['password'] == $this->user->getPassword()) {
                return true;
            } else {
                $this->respuesta["text"]='La contraseña no coincide';
                $this->respuesta["type"]=false;
                return false;
            }
        }
    }


    function __destruct()
    {

    }

}

?> 
