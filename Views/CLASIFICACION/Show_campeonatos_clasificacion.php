<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/CAMPEONATO/Showall_item.php';

	class Show_campeonatos_clasificacion{

		var $campeoantos;
        var $message;
    
        function __construct($campeoantos, $message){
            $this->campeoantos = $campeoantos;
            $this->message = $message;
            
            $this->pinta();
        }
    
        function pinta(){        
    
            ?>
                
                <?php new Header(); ?>            
                            <div class="card shadow " style="margin:0 10%">
                            
                                <div class="card-header bg-secondary border-0">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="mb-0">Clasificaciones de campeonatos</h3>
                                        </div>
                                        <div class="col text-right">
                                        </div>
                                    </div>
                                    <h6 class="heading-small text-muted mb-4" style="height: 10px">Aquí puedes ver los <b>ranking</b> de los campeonatos</h6>
                                </div>
                                
                                <div class="card-body" >
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center table-flush" data-order='[[ 1, "asc" ]]' id="example">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col" class="text-center">Nombre</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            // Loop through colors array
                                            if ($this->campeoantos != NULL) {
                                                foreach ($this->campeoantos as $key => $value ){ ?>
                                                    <tr>

                                                    <td class="text-center"><?php echo $value['nombre']?></td>
                                                    <td class="text-center">
                                                        <a href="../Controllers/CLASIFICACION_Controller.php?action=SHOW_ENFRENTA&campeonato_id=<?=$value['id']?>">
                                                            <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                <span class="btn-inner--text">Ranking</span>
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