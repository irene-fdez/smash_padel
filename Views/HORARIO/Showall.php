<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/HORARIO/Showall_item.php';

    class Showall {

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
                                        <h3 class="mb-0"><?php echo $_SESSION['currentEntity']?>s</h3>
                                    </div>
                                    <div class="col text-right">
                                        <!--a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SEARCH" class="btn btn-sm btn-success">Buscar</a-->
                                        <a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=ADD" class="btn btn-sm btn-success">Añadir</a>
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px">Añade o Elimina los horarios permitidos por el club</h6>
                            </div>

                            <div class="card-body">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush" data-order='[[ 0, "asc" ]]' id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <?php 
                                                if ($this->labels != NULL) {
                                                    foreach($this->labels as $val) { ?>
                                                        <?php if($val != 'id'){ ?>
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
                <?php new Footer($this->message); ?>
        <?php
    
        }
    }
?>