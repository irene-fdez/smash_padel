<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Gestion_horarios
{
    var $oferta_usuario_pareja1;
    var $oferta_usuario_pareja2;
    var $oferta_propuesta_pareja1;
    var $oferta_propuesta_pareja2;
    var $enfrent_sin_oferta_pareja1;
    var $enfrent_sin_oferta_pareja2;

    function __construct($oferta_usuario_pareja1, $oferta_usuario_pareja2, $oferta_propuesta_pareja1, $oferta_propuesta_pareja2, $enfrent_sin_oferta_pareja1, $enfrent_sin_oferta_pareja2, $opcion)
    {
        $this->ofertas_p1 =  $oferta_usuario_pareja1;
        $this->ofertas_p2 = $oferta_usuario_pareja2;
        $this->propuestas_p1 = $oferta_propuesta_pareja1;
        $this->propuestas_p2 = $oferta_propuesta_pareja2;
        $this->enfr_no_oferta_p1 = $enfrent_sin_oferta_pareja1;
        $this->enfr_no_oferta_p2 = $enfrent_sin_oferta_pareja2;

        if($opcion == 'enfrentamientos'){
            $this->pinta_enfr_no_oferta();
        }elseif($opcion == 'propuestas'){
            $this->pinta_propuestas();
        }else{
            $this->pinta_ofertas();
        }

        //$this->pinta();
    }

    function pinta_ofertas()
    {

        ?>
        <?php new Header(); ?>

        <div class="card shadow">

            <div class="card-header bg-secondary border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Horarios de Enfrentamientos</h3>
                    </div>
                    <div class="col text-right">
                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO&opcion=propuestas" class="btn btn-sm btn-primary">Tus propuestas</a>
                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO&opcion=enfrentamientos" class="btn btn-sm btn-primary">Enfrentamientos sin ofertas</a>
                    </div>
                </div>
                <h6 class="heading-small text-muted mb-4" style="height: 10px">Gestiona los horarios para tus enfrentamientos como <b>capitán</b></h6>
            </div>

           
            <!-- propuestas que te han realizado -->
            <div class="card-body">
            <h6 class="heading-title  mb-4" style="text-transform:capitalize; color: #172b4d">Propuestas ofrecidas</h6>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush " data-order='[[ 0, "asc" ]]' id="example">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Campeonato</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Grupo</th>
                                <th scope="col">Oponente</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        // Loop through colors array
                        if ($this->ofertas_p1 != NULL) {
                            foreach ($this->ofertas_p1 as $key => $value ){ ?>
                                <tr>
                                    <td><?= $value['campeonato_nombre']?></td>
                                    <td><?= $value['nivel'].' - '.$value['genero']?></td>
                                    <td>Grupo <?= $value['grupo_nombre']?></td>
                                    <td><?= $value['capitan']?></td>
                                    <td class="text-center">
                                        <a href="../Controllers/HUECO_DISPONIBLE_Controller.php?action=SHOW_OFERTAS&enfrentamiento_id=<?=$value['enfrentamiento_id']?>&pareja_id=<?=$value['pareja_id']?>">
                                            <div class="btn btn-sm btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                <span class="btn-inner--text">Mostrar ofertas</span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                        <?php  }          
                        } ?>
                        <?php
                        // Loop through colors array
                        if ($this->ofertas_p2 != NULL) {
                            foreach ($this->ofertas_p2 as $key => $value ){ ?>
                                <tr>
                                    <td><?= $value['campeonato_nombre']?></td>
                                    <td><?= $value['nivel'].' - '.$value['genero']?></td>
                                    <td>Grupo <?= $value['grupo_nombre']?></td>
                                    <td><?= $value['capitan']?></td>
                                    <td class="text-center">
                                        <a href="../Controllers/HUECO_DISPONIBLE_Controller.php?action=SHOW_OFERTAS&enfrentamiento_id=<?=$value['enfrentamiento_id']?>&pareja_id=<?=$value['pareja_id']?>">
                                            <div class="btn btn-sm btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                <span class="btn-inner--text">Mostrar ofertas</span>
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
                        <div class="btn btn-icon btn-3 btn-default">
                            <span class="btn-inner--text">Atras</span>
                        </div>
                    </a>
            </div>

        </div>
        <?php new Footer(array()); ?>
        <?php
    }

    function pinta_propuestas()
    {

        ?>
        <?php new Header(); ?>

        <div class="card shadow">
            <div class="card-header bg-secondary border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Horarios de Enfrentamientos</h3>
                    </div>
                    <div class="col text-right">
                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO" class="btn btn-sm btn-primary">Tus ofertas</a>
                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO&opcion=enfrentamientos" class="btn btn-sm btn-primary">Enfrentamientos sin ofertas</a>
                    </div>
                </div>
                <h6 class="heading-small text-muted mb-4" style="height: 10px">Gestiona los horarios para tus enfrentamientos como <b>capitán</b></h6>
            </div>

            
            <!-- propuestas que tu has realizado -->
            <div class="card-body">
            <h6 class="heading-title  mb-4" style="text-transform:capitalize; color: #172b4d">Tus propuestas realizadas</h6>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush " data-order='[[ 0, "asc" ]]' id="example">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Campeonato</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Grupo</th>
                                <th scope="col">Oponente</th>
                                <!--th scope="col">Fecha</th>
                                <th scope="col">Franja horaria</th-->

                                
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        // Loop through colors array
                        if ($this->propuestas_p1 != NULL) {
                            foreach ($this->propuestas_p1 as $key => $value ){ ?>
                                <tr style="height: 50px;">
                                    <td><?= $value['campeonato_nombre']?></td>
                                    <td><?= $value['nivel'].' - '.$value['genero']?></td>
                                    <td>Grupo <?= $value['grupo_nombre']?></td>
                                    <td><?= $value['capitan_oponente']?></td>
                                    <!--td><?php $fecha = explode("-", $value['fecha']);  echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                                    <td><?= substr($value['hora_inicio'], 0, 5).' - '.substr($value['hora_fin'], 0, 5);?></td-->
                                    <td class="text-center">
                                        <a href="../Controllers/HUECO_DISPONIBLE_Controller.php?action=SHOW_TUS_PROPUESTAS&enfrentamiento_id=<?=$value['enfrentamiento_id']?>&pareja_id=<?=$value['pareja_id']?>">
                                            <div class="btn btn-sm btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                <span class="btn-inner--text">Mostrar propuestas</span>
                                            </div>
                                        </a>
                                    </td>
                
                                </tr>
                        <?php  }          
                        } ?>
                        <?php
                        // Loop through colors array
                        if ($this->propuestas_p2 != NULL) {
                            foreach ($this->propuestas_p2 as $key => $value ){ ?>
                                <tr style="height: 50px;">
                                    <td><?= $value['campeonato_nombre']?></td>
                                    <td><?= $value['nivel'].' - '.$value['genero']?></td>
                                    <td>Grupo <?= $value['grupo_nombre']?></td>
                                    <td><?= $value['capitan_oponente']?></td>
                                    <!--td><?php $fecha = explode("-", $value['fecha']);  echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                                    <td><?= substr($value['hora_inicio'], 0, 5).' - '.substr($value['hora_fin'], 0, 5);?></td-->
                                    <td class="text-center">
                                        <a href="../Controllers/HUECO_DISPONIBLE_Controller.php?action=SHOW_TUS_PROPUESTAS&enfrentamiento_id=<?=$value['enfrentamiento_id']?>&pareja_id=<?=$value['pareja_id']?>">
                                            <div class="btn btn-sm btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                <span class="btn-inner--text">Mostrar propuestas</span>
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
                        <div class="btn btn-icon btn-3 btn-default">
                            <span class="btn-inner--text">Atras</span>
                        </div>
                    </a>
            </div>

        </div>
        <?php new Footer(array()); ?>
        <?php
    }


    function pinta_enfr_no_oferta()
    {

        ?>
        <?php new Header(); ?>

        <div class="card shadow">
            <div class="card-header bg-secondary border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Horarios de Enfrentamientos</h3>
                    </div>
                    <div class="col text-right">
                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO" class="btn btn-sm btn-primary">Tus ofertas</a>
                        <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO&opcion=propuestas" class="btn btn-sm btn-primary">Tus propuestas</a>
                    </div>
                </div>
                <h6 class="heading-small text-muted mb-4" style="height: 10px">Gestiona los horarios para tus enfrentamientos como <b>capitán</b></h6>
            </div>

            <!-- enfrentamientos sin propuestas -->
            <div class="card-body">
            <h6 class="heading-title  mb-4" style="text-transform:capitalize; color: #172b4d">Enfrentamientos sin propuestas</h6>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush " data-order='[[ 2, "asc" ]]' id="example">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Campeonato</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Grupo</th>
                                <th scope="col">Oponente</th>
                                <th scope="col"></th>

                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        // Loop through colors array
                        if ($this->enfr_no_oferta_p1 != NULL) {
                            foreach ($this->enfr_no_oferta_p1 as $key => $value ){ ?>
                                <tr>
                                    <td><?= $value['campeonato_nombre']?></td>
                                    <td><?= $value['nivel'].' - '.$value['genero']?></td>
                                    <td>Grupo <?= $value['grupo_nombre']?></td>
                                    <td><?= $value['capitan']?></td>

                                    <td class="text-center">
                                        <a href="../Controllers/HUECO_DISPONIBLE_Controller.php?action=SHOW_HUECOS_DISPOBIBLES&enfrentamiento_id=<?=$value['enfrentamiento_id']?>&pareja_id=<?=$value['pareja_id']?>">
                                            <div class="btn btn-sm btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                <span class="btn-inner--text">Proponer horario</span>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                        <?php  }          
                        } ?>
                        <?php
                        // Loop through colors array
                        if ($this->enfr_no_oferta_p2 != NULL) {
                            foreach ($this->enfr_no_oferta_p2 as $key => $value ){ ?>
                                <tr>
                                    <td><?= $value['campeonato_nombre']?></td>
                                    <td><?= $value['nivel'].' - '.$value['genero']?></td>
                                    <td>Grupo <?= $value['grupo_nombre']?></td>
                                    <td><?= $value['capitan']?></td>

                                    <td class="text-center">
                                        <a href="../Controllers/HUECO_DISPONIBLE_Controller.php?action=SHOW_HUECOS_DISPOBIBLES&enfrentamiento_id=<?=$value['enfrentamiento_id']?>&pareja_id=<?=$value['pareja_id']?>">
                                            <div class="btn btn-sm btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                <span class="btn-inner--text">Proponer horario</span>
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
                        <div class="btn btn-icon btn-3 btn-default">
                            <span class="btn-inner--text">Atras</span>
                        </div>
                    </a>
            </div>

        </div>
        <?php new Footer(array()); ?>
        <?php
    }
}

?>
