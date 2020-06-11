<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Show_ranking
{
    var $datos_camp;
    var $camp_cat_grupo;
    var $clasificaciones;
    var $num_grupo;
    var $message;

    function __construct($datos_camp, $camp_cat_grupo, $clasificaciones, $num_grupo, $message)
    {
        $row_campeonato = $datos_camp->fetch_array();
        $this->nombre_campeonato = $row_campeonato['nombre'];
        $this->campeonato_id = $row_campeonato['id'];

        $row_camp_cat_grupo = $camp_cat_grupo->fetch_array();
        $this->nivel_cat = $row_camp_cat_grupo['nivel'];
        $this->genero_cat = $row_camp_cat_grupo['genero'];
        $this->nombre_grupo = $row_camp_cat_grupo['nombre_grupo'];

        $this->clasificaciones = $clasificaciones;
        $this->num_grupo = $num_grupo;
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
                                        <h3 class="mb-0"><b>RANKING</b> <?=$this->nombre_campeonato.' ('. $this->nivel_cat.' '.substr($this->genero_cat,0,-1).'a - Grupo '.$this->nombre_grupo.')'  ?> </h3>
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
                                <table class="table align-items-center table-flush ordenar" data-order='[[ 0, "asc" ]]' id="example">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">Posición</th>
                                            <th scope="col">Capitán</th>
                                            <th scope="col">Jugador 2</th>
                                            <th scope="col">Puntos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // Loop through colors array
                                        if ($this->clasificaciones != NULL) {
                                            $cont = 0;
                                            foreach ($this->clasificaciones as $key => $value){ ?>
                                                <tr style="height: 50px;">
                                                    <td> <?php echo $cont+=1  ?> </td>
                                                    <td> <?php echo $value['capitan']?> </td>
                                                    <td> <?php echo $value['jugador_2']?> </td>
                                                    <td> <?php echo $value['puntos'] ?> </td>
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
                       
                <!-- Footer -->
                <?php new Footer($this->message); ?>
        <?php
    
        }
    }
?>