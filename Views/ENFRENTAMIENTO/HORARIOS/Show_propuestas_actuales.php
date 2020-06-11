<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Show_propuestas_actuales
{
    var $propuestas_actuales;
    var $message;
    var $enfrentamiento_id;
    var $pareja_id;

    function __construct($propuestas_actuales, $message, $enfrentamiento_id, $pareja_id)
    {
        $this->propuestas_actuales = $propuestas_actuales;
        $this->message = $message;
        $this->enfrentamiento_id = $enfrentamiento_id;
        $this->pareja_id = $pareja_id;
        
        $this->pinta();
    }

    function pinta(){        

        ?>
            
            <?php new Header(); ?>            
                        <div class="card shadow">
                        
                            <div class="card-header bg-secondary border-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="mb-0">Propuestas actuales</h3>
                                    </div>
                                    <div class="col text-right">
                                        <a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SHOW_HUECOS_DISPOBIBLES&enfrentamiento_id=<?=$this->enfrentamiento_id?>&pareja_id=<?=$this->pareja_id?>"
                                                 class="btn btn-sm btn-success">Añadir propuesta</a>
                                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO&opcion=propuestas" class="btn btn-sm btn-primary">Terminar propuestas</a>
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px"><b>Añade</b> o <b>Termina</b> tus propuestas de disponibilidad</h6>
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
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Loop through colors array
                                            if ($this->propuestas_actuales != NULL) {
                                                foreach ($this->propuestas_actuales as $key => $value){ ?>
                                                    <tr>
                                                    <td> <?php $fecha = explode("-", $value['fecha']);  echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                                                        <td> <?php echo substr($value['hora_inicio'], 0, 5); ?> </td>
                                                        <td> <?php echo substr($value['hora_fin'], 0, 5); ?> </td>
                                                    <?php  ?>
                                                        <td class="text-right">
                                                            <button class="btn btn-icon btn-2  btn-outline-danger  btn-sm" type="button" style="text-align: center;">
                                                                <a class="dropdown-item" href="#" data-toggle="modal" style="background-color: transparent;" data-target="#ModalDelete" data-whatever="<?php echo $value['hueco_id']; ?>">
                                                                    <span class="btn-inner--icon" style="background-color: transparent;"><i class="fas fa-trash"></i></span>
                                                                </a>
                                                            </button>
                                                            
                                                        </td>
                                                    </tr>
                                            <?php  }          
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-4">
                            <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO&opcion=propuestas">
                                <div class="btn btn-icon btn-default" style="margin-top: 1%">
                                    <span class="btn-inner--text">Atras</span>
                                </div>
                            </a>        
                            </div>
                        </div>         
                        <!-- Modal Delete-->
                        <form class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
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
                            </form>
                    
                <!-- Footer -->
                <?php new Footer($this->message); ?>
        <?php
    
        }
    }
?>