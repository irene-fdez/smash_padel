<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Add_resultados_enfrentamiento
{
    var $data;

    function __construct($data)
    {
        $enfrenta = $data->fetch_array();  
        $this->campeonato = $enfrenta['nombre_campeonato'];
        $this->cat_grupo = $enfrenta['nivel'].' '.substr($enfrenta['genero'],0,-1).'a - Grupo '.$enfrenta['nombre_grupo'];
        $this->pareja1 = $enfrenta['capitan_p1'].' y '.$enfrenta['jugador2_p1'];
        $this->pareja2 = $enfrenta['capitan_p2'].' y '.$enfrenta['jugador2_p2'];
        $this->fecha = explode("-", $enfrenta['fecha']);  
        $this->horario = substr($enfrenta['hora_inicio'], 0, 5).' - '.substr($enfrenta['hora_fin'], 0, 5);

        $this->enfrentamiento_id = $enfrenta['enfrentamiento_id'];
        $this->grupo_id = $enfrenta['grupo_id'];
        $this->categoria_id = $enfrenta['categoria_id'];
        $this->campeonato_id = $enfrenta['campeonato_id'];


   


        $this->pinta();
    }


    function pinta()
    {
        ?>
        <?php new Header(); ?>

        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h3 class="mb-0">Añade los resultados para el enfrentamiento  </h3>
                    </div>
                </div>
                <h6 class="heading-small text-muted mb-4" style="height: 10px"> 
                    <span style="text-transform: initial;">Enfrentamiento del </span> <?=$this->campeonato?> <span style="text-transform: capitalize;">(<?=$this->cat_grupo?>)</span>
                    <br> <span style="text-transform: initial;">jugado el </span>
                        <?=$this->fecha[2]."/".$this->fecha[1]."/".$this->fecha[0]?> 
                        <span style="text-transform: initial;"> de </span><?=$this->horario?>
                </h6>
            </div>
            <div class="card-body">
                <form role="form" name='add_resultado' enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentController']; ?>_Controller.php?action=ADD_RESULTADOS">
                    <h6 class="heading-small text-muted mb-4"></h6>

                    <input type="hidden" name="id" id="input-id" value="<?=$this->enfrentamiento_id?>" class="form-control form-control-alternative">
                    <input type="hidden" name="grupo_id" id="input-grupo_id" value="<?=$this->grupo_id?>" class="form-control form-control-alternative">
                    <input type="hidden" name="categoria_id" id="input-categoria_id" value="<?=$this->categoria_id?>" class="form-control form-control-alternative">

                    <!-- cabecera  y resultados 1er set -->
                    <div class="row">
                        <div class="col" style="margin-left: 25%; text-align: center; ">
                            <div class="form-group focused" >
                                <label class="form-control-label" for="input-pareja1">Pareja 1<br>(<?=$this->pareja1?>)</label>
                            </div>
                        </div>
                        <div class="col">
                            <label class="form-control-label" ></label>
                        </div>
                        <div class="col" style="margin-right: 25%; text-align: center; " >
                            <div class="form-group focused" >
                                <label class="form-control-label" for="input-pareja2">Pareja 2<br>(<?=$this->pareja2?>)</label>
                            </div>
                        </div>
                    </div>

                    <!-- resultados 1er set -->
                    <div class="row">
                        <div class="col" style="margin-left: 20%;" >
                            <div class="form-group focused" >
                                <input class="form-control" type="number" maxlength="1" min="0" max="7" value="0"  id="set1_p1" name="set1_p1" onblur="comprobar_sets()">
                            </div>
                        </div>
                        <div class="col" style="text-align: center; max-width: 5px;">
                            <label class="form-control-label"> - </label>
                        </div>
                        <div class="col" style="margin-right: 20%;">
                            <div class="form-group focused" >
                                <input class="form-control" type="number" maxlength="1" min="0" max="7" value="0" id="set1_p2" name="set1_p2" onblur="comprobar_sets()">
                            </div>
                        </div>
                    </div>

                    <!-- resultados 2o set -->
                    <div class="row">
                        <div class="col" style="margin-left: 20%;" >
                            <div class="form-group focused" >
                                <input class="form-control" type="number" maxlength="1" min="0" max="7" value="0" id="set2_p1" name="set2_p1" onblur="comprobar_sets()">
                            </div>
                        </div>
                        <div class="col" style="text-align: center; max-width: 5px;">
                            <label class="form-control-label"> - </label>
                        </div>
                        <div class="col" style="margin-right: 20%;">
                            <div class="form-group focused" >
                                <input class="form-control" type="number" maxlength="1" min="0" max="7" value="0" id="set2_p2" name="set2_p2" onblur="comprobar_sets()">
                            </div>
                        </div>
                    </div>

                    <!-- resultados 3er set -->
                    <div class="row">
                        <div class="col" style="margin-left: 20%;" >
                            <div class="form-group focused" >
                                <input class="form-control" type="number" maxlength="1" min="0" max="7" value="0" id="set3_p1" name="set3_p1" onblur="comprobar_sets()">
                            </div>
                        </div>
                        <div class="col" style="text-align: center; max-width: 5px;">
                            <label class="form-control-label"> - </label>
                        </div>
                        <div class="col" style="margin-right: 20%;">
                            <div class="form-group focused" >
                                <input class="form-control" type="number" maxlength="1" min="0" max="7" value="0" id="set3_p2" name="set3_p2" onblur="comprobar_sets()">
                            </div>
                        </div>
                    </div>

                    
                    <hr class="my-4">
                    <!--button class="btn btn-icon btn-3 btn-success" type="submit"> 
                        <span class="btn-inner--text">Enviar</span>
                    </button-->

                    <button class="btn btn-icon btn-3 btn-success" type="button" onclick="comprobar_resultados()" > 
                        <span class="btn-inner--text">Enviar</span>
                    </button>

                    <a href="../Controllers/ENFRENTAMIENTO_Controller.php?action=RESULTADOS&campeonato_id=<?=$this->campeonato_id?>&grupo_id=<?=$this->grupo_id?>&categoria_id=<?=$this->categoria_id?>">
                        <div class="btn btn-icon btn-3 btn-default">
                            <span class="btn-inner--text">Atras</span>
                        </div>
                    </a>
                </form>

                <!-- codigo de aviso rellenar resultados -->
                <div class="col-md-4">
                    <button type="button" style="display:none" id="aviso_envio" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification"></button>
                    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-10" role="document">
                        <div class="modal-content bg-gradient-danger">
                            
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal-title-notification">ATENCIÓN</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                
                                <div class="py-3 text-center">
                                    <i class="ni ni-bell-55 ni-3x"></i>
                                    <h4 class="heading mt-4">No ha introducido los resultados!</h4>
                                    <p>Recuerde rellenar las casilla con los resultados del enfrentamiento</p>
                                </div>
                                
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Aceptar</button> 
                            </div>
                            
                        </div>
                    </div>
                    </div>
                </div>


                <!-- codigo de aviso rellenar 3er set -->
                <div class="col-md-4">
                    <button type="button" style="display:none" id="aviso_set3" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification2"></button>
                    <div class="modal fade" id="modal-notification2" tabindex="-1" role="dialog" aria-labelledby="modal-notification2" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-10" role="document">
                        <div class="modal-content bg-gradient-danger">
                            
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal-title-notification">ATENCIÓN</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                
                                <div class="py-3 text-center">
                                    <i class="ni ni-bell-55 ni-3x"></i>
                                    <h4 class="heading mt-4">No hay ganador en los dos primeros sets!</h4>
                                    <p>Recuerde rellenar los resultados del 3<sup>er</sup> set</p>
                                </div>
                                
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Aceptar</button> 
                            </div>
                            
                        </div>
                    </div>
                    </div>
                </div>


                <!-- codigo de aviso rellenar puntuaciones -->
                <div class="col-md-4">
                    <button type="button" style="display:none" id="aviso_6" class="btn btn-block btn-warning mb-3" data-toggle="modal" data-target="#modal-notification3"></button>
                    <div class="modal fade" id="modal-notification3" tabindex="-1" role="dialog" aria-labelledby="modal-notification3" aria-hidden="true">
                    <div class="modal-dialog modal-danger modal-dialog-centered modal-10" role="document">
                        <div class="modal-content bg-gradient-danger">
                            
                            <div class="modal-header">
                                <h6 class="modal-title" id="modal-title-notification">ATENCIÓN</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <div class="modal-body">
                                
                                <div class="py-3 text-center">
                                    <i class="ni ni-bell-55 ni-3x"></i>
                                    <h4 class="heading mt-4">Hay algún error en los resultados!</h4>
                                    <p>Revise que los resultados introducidos son correctos</p>
                                </div>
                                
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-white" data-dismiss="modal">Aceptar</button> 
                            </div>
                            
                        </div>
                    </div>
                    </div>
                </div>
        </div>
        <?php new Footer(array()); ?>
        <?php
    }




}//fin clase

?>
