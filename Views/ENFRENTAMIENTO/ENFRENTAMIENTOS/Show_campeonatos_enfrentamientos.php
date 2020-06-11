<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Show_campeonatos_enfrentamientos
{
    var $campeonatos_enfret;
    var $message;

    function __construct($campeonatos_enfret, $message)
    {
        $this->campeonatos_enfret = $campeonatos_enfret;
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
                                        <h3 class="mb-0"> Campeonatos </h3>
                                    </div>
                                    <div class="col text-right">
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px">Elige el campeonato para el que quieres ver los enfrentamientos</h6>
                            </div>

                            <div class="card-body">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush ordenar" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col" ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Loop through colors array
                                            if ($this->campeonatos_enfret != NULL) {
                                                foreach ($this->campeonatos_enfret as $key => $value){ ?>
                                                    <tr>
                                                    <td> <?php echo $value['nombre']  ?> </td>
                                                    <td> <?php $fecha = explode("-", $value['fecha']);  echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                                                    <?php  ?>

                                                    <td class="text-center" style="width: 35%;">

                                                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_ENFRENTA&campeonato_id=<?=$value['id']?>">
                                                            <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                <span class="btn-inner--text">Ver Enfrentamientos</span>
                                                            </div>
                                                        </a>

                                                        <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ ?>
                                                            <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=SHOW_ENFRENTA&campeonato_id=<?=$value['id']?>&add_result=true">
                                                                <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                    <span class="btn-inner--text">Introducir resultados</span>
                                                                </div>
                                                            </a>
                                                        <?php } ?>
                                                    </td>
                                                        
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
                        <!--form class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
                            role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?=$_SESSION['currentController']?>_Controller.php?action=DELETE&id=<?=$value['hueco_id']?>&enfrentamiento_id=<?=$this->enfrentamiento_id?>&pareja_id=<?=$this->pareja_id?>">
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
                            </form-->
                    
                <!-- Footer -->
                <?php new Footer($this->message); ?>
        <?php
    
        }
    }
?>