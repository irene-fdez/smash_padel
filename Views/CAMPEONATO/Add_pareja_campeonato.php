<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Add_pareja_campeonato
{
    var $data;

    function __construct($data)
    {
        $this->Usuarios = $data[0];
        $this->Usuarios_rev = $data[1];
        $this->campeonato_id = $_REQUEST['campeonato_id'];
        
        if($_SESSION['rol']['nombre'] == 'Administrador'){
            $this->pinta_admin();
        }else{
            $this->capitan = $_SESSION['login'];
            $this->pinta();
        }
    }

    function pinta_admin()
    {

        ?>
        <?php new Header(); ?>

        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Añadir pareja</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form role="form" name='add_pareja' enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentController']; ?>_Controller.php?action=ADD_PAREJA">
                    <h6 class="heading-small text-muted mb-4"></h6>

                    <input type="hidden" name="campeonato_id" id="input-id" value="<?=$this->campeonato_id?>" class="form-control form-control-alternative">

                    <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="input-capitan">Capitan</label>
                            <select readonly class="browser-default custom-select" name="capitan" id="input-capitan" >
                            <?php
                                foreach($this->Usuarios as $row) { ?>
                                    <option value="<?php echo $row['login']; ?>"><?php echo $row['login'].'  ('.$row['nombre'].' '.$row['apellidos'].')'?></option>
                            <?php } ?>
                            </select>
                        </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-control-label" for="input-jugador2">Pareja</label>
                            <select readonly class="browser-default custom-select" name="jugador2" id="input-jugador2" >
                            <?php
                                foreach($this->Usuarios_rev as $row) { ?>
                                    <option value="<?php echo $row['login']; ?>"><?php echo $row['login'].'  ('.$row['nombre'].' '.$row['apellidos'].')'?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>

                    
                    <hr class="my-4">
                    <button class="btn btn-icon btn-3 btn-success" type="button" onclick="comprobar_pareja()" > 
                        <span class="btn-inner--text">Enviar</span>
                    </button>
                    <a href="../Controllers/CAMPEONATO_Controller.php">
                        <div class="btn btn-icon btn-3 btn-default">
                            <span class="btn-inner--text">Atras</span>
                        </div>
                    </a>
                </form>
                <!-- codigo de aviso cuando las parejas osn iguales -->
                <div class="col-md-4">
                    <button type="button" style="display:none" id="aviso_pareja_igual" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification"></button>
                    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-10" role="document">
                        <div class="modal-content bg-gradient-danger">
                            
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal-title-notification">ATENCIÓN</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                
                                <div class="py-3 text-center">
                                    <i class="ni ni-bell-55 ni-3x"></i>
                                    <h4 class="heading mt-4">Has introducido el mismo login para ambos jugadores</h4>
                                    <p>Los logins de ambos jugadores no pueden ser iguales!</p>
                                </div>
                                
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Aceptar</button> 
                            </div>
                            
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <?php new Footer(array()); ?>
        <?php
    }


    function pinta()
    {

        ?>
        <?php new Header(); ?>

        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Añadir pareja</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form role="form" name='add_pareja' enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentController']; ?>_Controller.php?action=ADD_PAREJA">
                    <h6 class="heading-small text-muted mb-4"></h6>

                    <input type="hidden" name="campeonato_id" id="input-id" value="<?=$this->campeonato_id?>" class="form-control form-control-alternative">

                    <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="input-capitan">Capitan</label>
                            <?php
                                foreach($this->Usuarios as $row) { ?>
                                <?php if($row['login'] == $this->capitan){ ?>
                                    <input type="text" class="form-control"  value="<?=$this->capitan.'  ('.$row['nombre'].' '.$row['apellidos'].')'?>" readonly>
                                    <input type="hidden" class="form-control" name="capitan" value="<?=$this->capitan?>" readonly>
                                <?php }?>
                            <?php } ?>
                            
                        </div>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-control-label" for="input-jugador2">Pareja</label>
                            <select readonly class="browser-default custom-select" name="jugador2" id="input-jugador2" >
                            <?php
                                foreach($this->Usuarios_rev as $row) { ?>
                                    <?php if($row['login'] != $this->capitan){ ?>
                                        <option value="<?php echo $row['login']; ?>"><?php echo $row['login'].'  ('.$row['nombre'].' '.$row['apellidos'].')'?></option>
                                    <?php }?>
                            <?php } ?>
                            </select>
                        </div>
                    </div>

                    
                    <hr class="my-4">
                    <button class="btn btn-icon btn-3 btn-success" type="submit"> 
                        <span class="btn-inner--text">Enviar</span>
                    </button>
                    <a href="../Controllers/CAMPEONATO_Controller.php">
                        <div class="btn btn-icon btn-3 btn-default">
                            <span class="btn-inner--text">Atras</span>
                        </div>
                    </a>
                </form>
            </div>
        </div>
        <?php new Footer(array()); ?>
        <?php
    }




}//fin clase

?>
