<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
   // include_once '../Views/PARTIDO/Showall_item.php';

    class Show_inscritos_partido {

        function __construct(){
            $params = func_get_args();
            $num_params = func_num_args();
    
            $function_construct = '__construct'.$num_params;
            
            if (method_exists($this,$function_construct)) {
                call_user_func_array(array($this,$function_construct),$params);
            }
            
        }

        function __construct6($data, $labels, $message, $fecha, $hora_inicio, $hora_fin){

            $this->data = $data;
            $this->labels = $labels;
            $this->message = $message;

            $fecha = explode("-", $fecha);
            $this->fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];

            $this->hora_inicio = substr($hora_inicio, 0, 5);
            $this->hora_fin = substr($hora_fin, 0, 5);


            $this->pinta_partido();
        }

    function pinta_partido(){        

        ?>
            
            <?php new Header(); ?>            
                        <div class="card shadow">
                        
                            <div class="card-header bg-secondary border-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="mb-0"> Usuarios inscritos en el partido del día <?= $this->fecha ?>, 
                                                de <?=$this->hora_inicio ?> a <?= $this->hora_fin ?> </h3>
                                    </div>
                                    <div class="col text-right">
                                        
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px"></h6>
                            </div>
                            
                            <div class="card-body">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush ordenar" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <?php 
                                                if ($this->labels != NULL) {
                                                    foreach($this->labels as $val) { ?>
                                                        <?php if($val != 'fecha'  && $val != 'hora_inicio' && $val != 'hora_fin' && $val != 'reserva' && $val != 'id_partido' ){ ?>
                                                            <th scope="col"><?php echo $val; ?></th>
                                                        <?php } ?>
                                            <?php   } 
                                                }?> 
                                            <?php if ( $this->data->num_rows < 4 && ($_SESSION['rol']['nombre'] == "Administrador")){ ?>
                                                <th scope="col"></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Loop through colors array
                                            if ($this->data != NULL) {
                                                foreach ($this->data as $key => $value){ ?>
                                                    <tr style="height: 50px;">
                                                        <td> <?php echo $value['login']; ?> </td>
                                                        <td> <?php echo $value['nombre']; ?> </td>
                                                        <td> <?php echo $value['apellidos']; ?> </td>
                                                    <?php if ($value['reserva'] == NULL && ($_SESSION['rol']['nombre'] == "Administrador")){ ?>
                                                        <td class="text-right">
                                                            <input style="display:none" name="login" readonly value="<?=$value['login'];?>">
                                                            <input style="display:none" name="id_partido" readonly value="<?=$value['id_partido'];?>">
                                                            
                                                            <a href="../Controllers/../Controllers/USUARIO_PARTIDO_Controller.php?action=DELETE&id_partido=<?=$value['id_partido']?>&login=<?=$value['login']?>">
                                                                <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                    <span class="btn-inner--text">Borrar</span>
                                                                </div>
                                                            </a>  
                                                        </td>
                                                    <?php } ?>
                                                    </tr>
                                            <?php  }          
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-4">
                            <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ ?> 
                                <a href="../Controllers/PARTIDO_Controller.php?action=SHOWALL_PARTIDOS_INSCRIPCION">
                            <?php }else{ ?> 
                                <a href="../Controllers/PARTIDO_Controller.php?action=INSCRIPCIONES_USER_PARTIDOS">
                            <?php } ?>
                                    <div class="btn btn-icon btn-default" style="margin-top: 1%">
                                        <span class="btn-inner--text">Atras</span>
                                    </div>
                                </a>     
                                
                            </div>
                        </div>
                        <!-- Modal Delete-->
                        <form class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                            role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=DELETE">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">¿Eliminar usuario?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estas segur@ de eliminar este usuario?
                                        <input type="hidden" name="<?php echo $_SESSION['currentKey']?>" class="form-control" id="recipient-name">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <button type="submit" class="btn btn-danger">Si</button>
                                    </div>
                                    </div>
                                </div>
                            </form>
                    
                <!-- Footer -->
                <?php new Footer($this->message); ?>
        <?php
    
        }
    }
?>