<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';

	class Showall_campeonato_usuario{

		var $campeonatos;
        var $message;
    
        function __construct($campeonatos, $message){
            $this->campeonatos = $campeonatos;
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
                                            <h3 class="mb-0">Tus <?php echo $_SESSION['currentEntity']?>s</h3>
                                        </div>
                                        <div class="col text-right">
                                            <?php if($_SESSION["rol"]["nombre"] == 'Administrador'){ ?>
                                                <a href="../Controllers/CAMPEONATO_Controller.php?action=ADD" class="btn btn-sm btn-success">Crear campeonato</a>
                                            <?php } ?>
                                            <a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php" class="btn btn-sm btn-outline-secondary" style="border-color: #172b4d;">
                                                Apuntate aquí a otro campeonato!
                                            </a>
                                        </div>
                                    </div>
                                    <h6 class="heading-small text-muted mb-4" style="height: 10px">Campeonatos en los que estás inscrito</h6>
                                </div>
                                
                                <div class="card-body">
                                <div class="table-responsive">
                                    <!-- Projects table -->
                                    <table class="table align-items-center table-flush " data-order='[[ 0, "asc" ]]' id="example">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Campeonato</th>
                                                <th scope="col">Categoría</th>
                                                <th scope="col">Pareja</th>
                                                <th scope="col">Grupo</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            // Loop through colors array
                                            if ($this->campeonatos != NULL) {
                                                foreach ($this->campeonatos as $key => $value ){ ?>
                                                    <tr style="height: 60px;">
                                                        <td><?php echo $value[0]?></td>
                                                        <td><?php echo $value[1]?></td>
                                                        <td><?php echo $value[2]?></td>
                                                        <td><?php echo $value[3]?></td>
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