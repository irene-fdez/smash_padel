<?php

class Categoria_campeonato {

    var $id_campeonato;
	var $id_categoria; 
   
    function __construct($id_campeonato, $id_categoria){
		$this->id_campeonato = $id_campeonato;
		$this->id_categoria = $id_categoria;
    } 


    function getId_campeonato(){
        return $this->id_campeonato;
    }

    function setId_campeonato($id_campeonato){
        $this->id_campeonato = $id_campeonato;
    }

    
    function getId_categoria(){
        return $this->id_categoria;
    }

    function setId_categoria($id_categoria){
        $this->id_categoria = $id_categoria;
    }
    
    function check() {
        $error = false;

        if (strlen($this->id_campeonato) < 2) {
            $error = true;
        }

        if (strlen($this->id_categoria)  < 2) {
            $error = true;
        }

        return $error;
    }

}

?>
