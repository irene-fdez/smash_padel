<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Select_categoria_ranking
{
    var $datos_camp;
    var $cat_grupo;

    function __construct($datos_camp, $cat_grupo)
    {
        $row_camp = $datos_camp->fetch_array();
        $this->nombre_camp = $row_camp['nombre'];
        $this->campeonato_id = $row_camp['id'];
        $this->cat_grupo = $cat_grupo;
        
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
                        <h3 class="mb-0">Enfrentamientos  <?= $this->nombre_camp ?></h3>
                    </div>
                </div>
                <h6 class="heading-small text-muted mb-4">Selecciona una Categoría-Grupo del campeonato para ver su <b>ranking</b></h6>
            </div>
            <div class="card-body">
               
                    <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentController']; ?>_Controller.php?action=RANKING">
                    

                    <input type="hidden" name="campeonato_id" id="input-id" value="<?=$this->campeonato_id?>" class="form-control form-control-alternative">

                    <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="input-cat_grupo">Selecciona Categoria-Grupo</label>
                            <select readonly class="browser-default custom-select" name="cat_grupo" id="input-cat_grupo" >
                            <?php
                                foreach($this->cat_grupo as $row) { ?>
                                    <option value="<?php echo $row['categoria_id'].'-'.$row['grupo_id']; ?>"><?php echo $row['nivel'].' '.substr($row['genero'],0,-1).'a - Grupo '.$row['nombre_grupo']?></option>
                            <?php } ?>
                            </select>
                        </div>
                        </div>
                       
                    </div>
                    
                    <hr class="my-4">
                    <button class="btn btn-icon btn-3 btn-success" type="submit"  > 
                        <span class="btn-inner--text">Enviar</span>
                    </button>
                    <a href="../Controllers/CLASIFICACION_Controller.php">
                        <div class="btn btn-icon btn-3 btn-default">
                            <span class="btn-inner--text">Atras</span>
                        </div>
                    </a>
                </form>
            </div>
        </div>
        <?php new Footer(array()); ?>
        <?php
    }
}

?>
