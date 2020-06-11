<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
   // include_once '../Views/PARTIDO/Showall_item.php';

    class Inscribir_usuario_partido {

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

            $this->Alldata = $this->data->fetch_array();
            $fecha = explode("-", $this->Alldata['fecha']);
            $this->fecha = $fecha[2]."/".$fecha[1]."/".$fecha[0];
            
            $this->pinta_partido();
        }

    function pinta_partido(){        

        ?>
            
            <?php new Header(); ?>            
                        <div class="card shadow">
                        
                            <div class="card-header bg-secondary border-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="mb-0"> Selecciona un usuario para inscribir en el partido del día <?= $this->fecha ?>, 
                                                <br>de <?=substr($this->Alldata['hora_inicio'], 0, 5); ?> a <?=substr($this->Alldata['hora_fin'], 0, 5); ?> </h3>
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
                                                        <?php if($val != 'id_partido'  && $val != 'fecha'  && $val != 'hora_inicio'  && $val != 'hora_fin' ){ ?>
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
                                                    <tr>
                                                        <td> <?php echo $value['login']; ?> </td>
                                                        <td> <?php echo $value['nombre']; ?> </td>
                                                        <td> <?php echo $value['apellidos']; ?> </td>
                                                    <?php  ?>
                                                        <td class="text-right">
                                                            <input style="display:none" name="login" readonly value="<?=$value['login'];?>">
								                            <input style="display:none" name="id_partido" readonly value="<?=$value['id_partido'];?>">
                                                           
                                                            <a href="../Controllers/../Controllers/USUARIO_PARTIDO_Controller.php?action=ADD_INSCRIPCION&id_partido=<?=$value['id_partido']?>&login=<?=$value['login']?>">
                                                                <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                    <span class="btn-inner--text">Inscribir</span>
                                                                </div>
                                                            </a>  
                                                          
                                                        </td>
                                                    </tr>
                                            <?php  }          
                                            } ?>
                                        <?php           /*                                 
                                            if ($this->data != NULL) {
                                                foreach($this->data as $row){ 
                                                    new Showall_item($row, $this->labels);
                                                }
                                            }*/
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-4">
                            <a href="../Controllers/PARTIDO_Controller.php?action=INSCRIBIRSE_PARTIDO">
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
    }
?>