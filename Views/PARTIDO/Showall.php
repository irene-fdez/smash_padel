<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/PARTIDO/Showall_item.php';

    class Showall {

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

            $this->pinta_admin();
        }

        function __construct2($data, $labels){

            $this->data = $data;
            $this->labels = $labels;

            
            $this->pinta();
        }

    function pinta_admin(){        

        ?>
            
            <?php new Header(); ?>            
                        <div class="card shadow">
                        
                            <div class="card-header bg-secondary border-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="mb-0"><?php echo $_SESSION['currentEntity']?>s Promocionados</h3>
                                    </div>
                                    <div class="col text-right">
                                        <!--a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SEARCH" class="btn btn-sm btn-success">Buscar</a-->
                                        <a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SHOW_HORARIOS" class="btn btn-sm btn-success">Promocionar</a>
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px">Partidos promocionados por club</h6>
                            </div>

                            <div class="card-body">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <?php 
                                            if($this->data == NULL){ ?>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Hora inicio</th>
                                                <th scope="col">Hora finalización</th>
                                                <th scope="col">Inscripciones</th>
                                            <?php } else{
                                                    if ($this->labels != NULL) {
                                                        foreach($this->labels as $val) { ?>
                                                            <?php if($val != 'id'  && $val != 'horario' ){ ?>
                                                                <th scope="col"><?php echo $val; ?></th>
                                                            <?php } ?>
                                                <?php   } 
                                                    }
                                                }?>
                                            <th scope="col"></th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Loop through colors array
                                            
                                            if ($this->data != NULL) {
                                                foreach($this->data as $row){ 
                                                    new Showall_item($row, $this->labels);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-4">
                            <a href="../Controllers/LOGIN_Controller.php">
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
    
        }// fin pinta_admin


        function pinta(){        

            ?>
                
                <?php new Header(); ?>            
                            <div class="card shadow">
                            
                                <div class="card-header bg-secondary border-0">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="mb-0"> Tus inscripciones</h3>
                                        </div>
                                        <div class="col text-right">
                                            <!--a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SEARCH" class="btn btn-sm btn-success">Buscar</a-->
                                            <a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=INSCRIBIRSE_PARTIDO" class="btn btn-sm btn-success">Incribirse</a>
                                        </div>
                                    </div>
                                    <h6 class="heading-small text-muted mb-4" style="height: 10px;">Partidos en los que estás incrito</h6>
                                </div>
                                
                                <div class="card-body">
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center table-flush" id="example">
                                        <thead class="thead-light">
                                            <tr>
                                                <?php 
                                                if($this->data == NULL){ ?>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Hora inicio</th>
                                                    <th scope="col">Hora finalización</th>
                                                    <th scope="col">Inscripciones</th>
                                                <?php } else{
                                                        if ($this->labels != NULL) {
                                                            foreach($this->labels as $val) { ?>
                                                                <?php if($val != 'id'  && $val != 'horario' ){ ?>
                                                                    <th scope="col"><?php echo $val; ?></th>
                                                                <?php } ?>
                                                    <?php   } 
                                                        }
                                                    }?>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                // Loop through colors array
                                                
                                                if ($this->data != NULL) {
                                                    foreach($this->data as $row){ 
                                                        new Showall_item($row, $this->labels);
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                        </table>
                            </div>
                            <hr class="my-4">
                            <a href="../Controllers/LOGIN_Controller.php">
                                <div class="btn btn-icon btn-default" style="margin-top: 1%">
                                    <span class="btn-inner--text">Atras</span>
                                </div>
                            </a>        
                        </div>
                    </div>                  
                           
                    <!-- Footer -->
                    <?php new Footer(array()); ?>
            <?php
        
            }// fin pinta
        
    } //class Showall


?>