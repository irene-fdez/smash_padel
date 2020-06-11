<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/CAMPEONATO/Showall_item.php';

	class Showall_close{

		var $camp_enfrent;
        var $camp_no_enfrent;
        var $labels;
        var $message;
    
        function __construct($camp_enfrent, $camp_no_enfrent, $labels, $message){
            $this->camp_enfrent = $camp_enfrent;
            $this->camp_no_enfrent = $camp_no_enfrent;
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
                                            <h3 class="mb-0"><?php echo $_SESSION['currentEntity']?>s cerrados</h3>
                                        </div>
                                        <div class="col text-right">
                                            <?php if($_SESSION["rol"]["nombre"] == 'Administrador'){ ?>
                                                <a href="../Controllers/CAMPEONATO_Controller.php?action=ADD" class="btn btn-sm btn-success">Crear campeonato</a>
                                            <?php } ?>
                                            <!--a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SHOW_HORARIOS" class="btn btn-sm btn-success">Promocionar</a-->
                                        </div>
                                    </div>
                                    <h6 class="heading-small text-muted mb-4" style="height: 10px">Grupos y enfrentamientos sobre cada campeonato cerrado</h6>
                                </div>
                                
                                <div class="card-body">
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center table-flush" data-order='[[ 1, "asc" ]]' id="example">
                                        <thead class="thead-light">
                                            <tr>
                                                <?php 
                                                    if($this->camp_enfrent == NULL && $this->camp_no_enfrent == NULL){ ?>
                                                        <th scope="col">Nombre</th>
                                                        <th scope="col">Fecha</th>
                                                    <?php }else{ 
                                                        if ($this->labels != NULL) {
                                                            foreach($this->labels as $val) { ?>
                                                                <?php if($val != 'id'){ ?>
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
                                            if ($this->camp_no_enfrent != NULL) {
                                                foreach ($this->camp_no_enfrent as $key => $value ){ ?>
                                                    <tr>

                                                    <td><?php echo $value['nombre']?></td>
                                                    <td><?php echo $value['fecha']?></td>
                                                    <td class="text-right">
                                                        <a href="../Controllers/CAMPEONATO_Controller.php?action=GENERAR&id=<?=$value['id']?>">
                                                            <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                <span class="btn-inner--text">Generar Enfrentamientos</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    </tr>
                                            <?php  }          
                                            } ?>
                                            <?php
                                            // Loop through colors array
                                            if ($this->camp_enfrent != NULL) {
                                                foreach ($this->camp_enfrent as $key => $value ){ ?>
                                                    <tr>

                                                    <td><?php echo $value['nombre']?></td>
                                                    <td><?php echo $value['fecha']?></td>
                                                    <td class="text-right">
                                                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_ENFRENTA&campeonato_id=<?=$value['id']?>">
                                                            <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                <span class="btn-inner--text">Ver Enfrentamientos</span>
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