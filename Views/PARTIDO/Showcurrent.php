<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/Template/Showall_item.php';

    class Showcurrent {

        function __construct($data){

            $this->data = $data;
            $this->pinta();
        }

    function pinta(){        

        ?>
            <?php new Header(); ?>
                
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">

                    <div class="card-body pt-0 pt-md-4">
                    
                        <div class="">
                            
                            <?php foreach($this->data as $key=>$value) { 
                                if(!is_numeric($key) && $key != 'id' && ($_SESSION['currentEntity'] == 'Partido' && $key != 'horario') ) { ?>

                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin "></i><?php  echo $key ;?>
                                </div>
                                <h3>
                                <?php if($key == 'Hora inicio' || $key == 'Hora finalizacion'){ ?>
                                    <td><?php echo substr($value, 0, 5); ?></td>
                                <?php }
                                elseif($key == 'fecha'){ 
                                    $fecha = explode("-", $value);
                                    ?>
                                    <td><?php echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                                <?php }
                                else{ ?>
                                    <td><?php echo $value; ?></td>
                                <?php } ?>
                                    
                                </h3>

                            <?php 
                                    }
                                } 
                            ?>

                        </div>
                    </div>
                </div>
            
                <a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php">
                    <div class="btn btn-icon btn-default" style="margin-top: 2.5%">
                        <span class="btn-inner--text">Atras</span>
                    </div>
                </a>    
            </div>        
                <!-- Footer -->
                <?php new Footer(array()); ?>
        <?php
        }
    }
?>