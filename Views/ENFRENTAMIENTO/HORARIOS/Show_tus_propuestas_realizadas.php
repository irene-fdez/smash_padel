<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Show_tus_propuestas_realizadas
{
    var $huecos_propuestos;
    var $data;
    var $message;
    var $enfrentamiento_id;
    var $pareja_id;

    function __construct($huecos_propuestos, $data, $message, $enfrentamiento_id, $pareja_id)
    {
        $this->huecos_propuestos = $huecos_propuestos;
        $this->data = $data->fetch_array();
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
                                        <h3 class="mb-0">Tus huecos propuestos (<?= $this->data['campeonato_nombre'] ?>)</h3>
                                    </div>
                                    <div class="col text-right">
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px">
                                    Propuestas que has realizado para el enfrentamiento cuyos capitanes sois
                                    <b><span style="text-transform: capitalize;"><?= $this->data['capitan_p1']?></span> 
                                    <span style="text-transform: initial;"> y </span> 
                                    <span style="text-transform: capitalize;"><?= $this->data['capitan_p2'] ?></span></b>
                                </h6>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            // Loop through colors array
                                            if ($this->huecos_propuestos != NULL) {
                                                foreach ($this->huecos_propuestos as $key => $value){ ?>
                                                    <tr style="height: 50px;">
                                                    <td> <?php $fecha = explode("-", $value['fecha']);  echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                                                        <td> <?php echo substr($value['hora_inicio'], 0, 5); ?> </td>
                                                        <td> <?php echo substr($value['hora_fin'], 0, 5); ?> </td>
                                                    <?php  ?>

                                                    <!--td class="text-right">
                                                        <a href="../Controllers/HUECO_DISPONIBLE_Controller.php?action=ACEPTAR_PROPUESTA&enfrentamiento_id=<?=$this->enfrentamiento_id?>&horario_id=<?=$value['horario_id']?>&fecha=<?=$value['fecha']?>">
                                                            <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                <span class="btn-inner--text">Aceptar</span>
                                                            </div>
                                                        </a>
                                                    </td-->
                                                        
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