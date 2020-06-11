<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';

    class Showall_pistas_reserva {

        function __construct($data, $labels, $message){

            $this->data = $data;
            $this->labels = $labels;
            $this->message = $message;
            
            $this->pinta();
        }

    function pinta(){        
        ?>
            
            <?php new Header(); ?>            
                        <div class="card shadow">
                        
                            <div class="card-header bg-secondary border-0">
                                <div class="row align-items-center">
                                    <div class="col">

                                    <?php if($_SESSION['rol']['nombre'] == 'Deportista'){ ?>
                                        <h3 class="mb-0">Tus <?php echo $_SESSION['currentEntity']?>s</h3>
                                    <?php }
                                        else{ ?>
                                        <h3 class="mb-0"><?php echo $_SESSION['currentEntity']?>s</h3>
                                    <?php } ?>
                                        
                                    </div>
                                    <div class="col text-right">
                                        <a href="../Controllers/RESERVA_Controller.php" class="btn btn-sm btn-success">Nueva reserva</a>
                                    </div>
                                </div>
                                <?php if($_SESSION['rol']['nombre'] == 'Deportista'){ ?>
                                    <h6 class="heading-small text-muted mb-4" style="height: 10px;">Pistas en las que tienes reservas</h6>
                                <?php }else{ ?>
                                    <h6 class="heading-small text-muted mb-4" style="height: 10px;">Elige una pista para ver sus reservas</h6>
                                <?php } ?>
                            </div>
                            
                            <div class="card-body">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush" data-order='[[ 0, "asc" ]]' id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <?php 
                                            if($this->data != NULL){
                                                if ($this->labels != NULL) {
                                                    foreach($this->labels as $val) { ?>
                                                        <th scope="col"><?php echo $val; ?></th>
                                            <?php   } 
                                                }
                                            }else{?>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Tipo</th>
                                            <?php } ?>
                                            <th scope="col"></th>
                                            

                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                            if ($this->data != NULL) {
                                                foreach ($this->data as $key => $value){ ?>
                                                    <tr>
                                                        <td> <?php echo $value['nombre']; ?> </td>
                                                        <td> <?php echo $value['tipo']; ?> </td>
                                                    <?php  ?>
                                                        <td class="text-right">
                                                            <a href="../Controllers/<?=$_SESSION['currentController']?>_Controller.php?action=SHOW_RESERVAS_PISTA&nombre_pista=<?=$value['nombre']?>">
                                                                <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                    <span class="btn-inner--text">Ver reservas</span>
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
                            <a href="../Controllers/LOGIN_Controller.php">
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
    }
?>