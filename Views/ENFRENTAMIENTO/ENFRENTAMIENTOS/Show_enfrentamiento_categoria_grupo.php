<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Show_enfrentamiento_categoria_grupo
{
    var $datos_campeonato;
    var $datos_categoria;
    var $datos_grupo;
    var $fase_grupos;
    var $message;

    function __construct($datos_campeonato, $datos_categoria, $datos_grupo, $fase_grupos, $message)
    {
        $row_campeonato = $datos_campeonato->fetch_array();
        $this->nombre_campeonato = $row_campeonato['nombre'];
        $this->campeonato_id = $row_campeonato['id'];

        $row_cat = $datos_categoria->fetch_array();
        $this->nivel_cat = $row_cat['nivel'];
        $this->genero_cat = $row_cat['genero'];

        $row_grupo = $datos_grupo->fetch_array();
        $this->nombre_grupo = $row_grupo['nombre'];
        $this->grupo_id = $row_grupo['id'];


        $this->fase_grupos = $fase_grupos;
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
                                        <h3 class="mb-0"><?=$this->nombre_campeonato.' ('. $this->nivel_cat.' '.substr($this->genero_cat,0,-1).'a - Grupo '.$this->nombre_grupo.')'  ?> </h3>
                                    </div>
                                    <div class="col text-right">
                                        <a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SHOW_ENFRENTA&campeonato_id=<?=$this->campeonato_id?>"
                                                 class="btn btn-sm btn-outline-primary">Elige otra categoria-grupo</a>
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px">Fase de <b>Grupos</b></h6>
                            </div>

                            <div class="card-body">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush ordenar" id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Pareja 1<br><span style="text-transform: capitalize;">(Capitán - Jugador 2)</span></th>
                                            <th scope="col">Pareja 2<br><span style="text-transform: capitalize;">(Capitán - Jugador 2)</span></th>
                                            <th scope="col">Resultado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // Loop through colors array
                                        if ($this->fase_grupos != NULL) {
                                            foreach ($this->fase_grupos as $key => $value){ ?>
                                                <tr style="height: 50px;">
                                                    <td> <?php echo $value['capitan_p1'].' - '. $value['jugador2_p1']?> </td>
                                                    <td> <?php echo $value['capitan_p2'].' - '. $value['jugador2_p2']?> </td>
                                                    <?php if( $value['resultado'] == NULL){ ?>
                                                        <td style="color:#fb6340;"> No jugado </td>
                                                        
                                                    <?php }else{ ?>
                                                        <td> <?php echo $value['resultado'] ?> </td>
                                                        
                                                    <?php } ?>
                                                    
                                                    
                                                </tr>
                                        <?php  }          
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                            <hr class="my-4">
                            <a href="../Controllers/ENFRENTAMIENTO_Controller.php">
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