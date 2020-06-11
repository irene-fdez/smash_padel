<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
   // include_once '../Views/PARTIDO/Showall_item.php';

    class Inscribirse_partido {

        function __construct(){
            $params = func_get_args();
            $num_params = func_num_args();
    
            $function_construct = '__construct'.$num_params;
            
            if (method_exists($this,$function_construct)) {
                call_user_func_array(array($this,$function_construct),$params);
            }
            
        }

        function __construct3($data, $labels, $message){

            $this->data = $data;
            $this->labels = $labels;
            $this->message = $message;
            
            $this->pinta_partido_admin();
        }

        function __construct2($data, $message){

            $this->data = $data;
            $this->message = $message;
            $this->login = $_SESSION['login'];
            
            $this->pinta_partido();
        }

    function pinta_partido_admin(){        

        ?>
            
            <?php new Header(); ?>            
                        <div class="card shadow">
                        
                            <div class="card-header bg-secondary border-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="mb-0"><?php echo $_SESSION['currentEntity']?>s Promocionados</h3>
                                    </div>
                                    <div class="col text-right">
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px">Selecciona un usuario para inscribir en el partido</h6>
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
                                                        <?php if($val != 'id'  && $val != 'horario' ){ ?>
                                                            <th scope="col"><?php echo $val; ?></th>
                                                        <?php } ?>
                                            <?php   } 
                                                }?>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Loop through colors array
                                            if ($this->data != NULL) {
                                                foreach ($this->data as $key => $value){ ?>
                                                    <tr style="height: 60px;">
                                                        <td> <?php $fecha = explode("-", $value['fecha']);  echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                                                        <td> <?php echo substr($value['hora inicio'], 0, 5); ?> </td>
                                                        <td> <?php echo substr($value['hora fin'], 0, 5); ?> </td>
                                                        <td> <?php echo $value['inscripciones']; ?> </td>
                                                    
                                                        <td class="text-right">
                                                            <?php if( $value['inscripciones'] < 4 ){ ?>
                                                                <a href="../Controllers/<?=$_SESSION['currentController']?>_Controller.php?action=INSCRIPCION_USUARIO&id=<?=$value['id']?>">
                                                                    <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                        <span class="btn-inner--text">Inscribir</span>
                                                                    </div>
                                                                </a>  
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                            <?php  }          
                                            } ?>

                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <a href="../Controllers/PARTIDO_Controller.php?action=SHOWALL_PARTIDOS_INSCRIPCION">
                            <div class="btn btn-icon btn-default" style="margin-top: 1%">
                                <span class="btn-inner--text">Atras</span>
                            </div>
                         </a>                 
                        <!-- Modal Delete-->
                        <form class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                            role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=DELETE">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">¿Eliminar <?php echo $_SESSION['currentEntity']?>?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estas segur@ de eliminar esta entidad?
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


        function pinta_partido(){        
            ?>
                
                <?php new Header(); ?>            
                            <div class="card shadow">
                            
                                <div class="card-header bg-secondary border-0">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="mb-0"><?php echo $_SESSION['currentEntity']?>s Promocionados</h3>
                                        </div>
                                        <div class="col text-right">
                                        </div>
                                    </div>
                                    <h6 class="heading-small text-muted mb-4" style="height: 10px">Partidos en los que puedes inscribirte</h6>
                                </div>


                                <div class="card-body">
                                <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush ordenar" id="example">
                                    <thead class="thead-light">
                                        <tr>

                                            <th scope="col">Fecha</th>
                                            <th scope="col">Hora inicio</th>
                                            <th scope="col">Hora fin</th>
                                            <th scope="col">Inscripciones</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            // Loop through colors array
                                            if ($this->data != NULL) {
                                                foreach ($this->data as $key => $value){ ?>
                                                    <tr>
                                                        <td> <?php $fecha = explode("-", $value[0]);  echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                                                        <td> <?php echo substr($value[1], 0, 5); ?> </td>
                                                        <td> <?php echo substr($value[2], 0, 5); ?> </td>
                                                        <td> <?php echo $value[3]; ?> </td>

                                                
                                                        <td class="text-right">
								                            <input style="display:none" name="id_partido" readonly value="<?=$key;?>">
                                                           

                                                            <a href="../Controllers/../Controllers/USUARIO_PARTIDO_Controller.php?action=ADD_INSCRIPCION&id_partido=<?=$key?>&login=<?=$this->login?>">
                                                                <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                    <span class="btn-inner--text">Inscribirse</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                    </tr>
                                            <?php  }          
                                            } ?>
                                    </tbody>
                                        
                                    </table>
                                </div>
                                <hr class="my-4">
                                <a href="../Controllers/PARTIDO_Controller.php?action=INSCRIPCIONES_USER_PARTIDOS">
                                    <div class="btn btn-icon btn-default" style="margin-top: 1%">
                                        <span class="btn-inner--text">Atras</span>
                                    </div>
                                </a>     
                                </div>
                            </div>            
                            
                    <!-- Footer -->
                    <?php new Footer($this->message); ?>
            <?php
        
            }

    } //fin clase
?>