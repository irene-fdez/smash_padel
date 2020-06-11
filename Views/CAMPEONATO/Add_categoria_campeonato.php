<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Add_categoria_campeonato
{
    var $data;

    function __construct($data, $pareja_id, $campeonato_id)
    {
        $this->Categorias = $data;
        $this->pareja_id = $pareja_id;  
        $this->campeonato_id = $campeonato_id;
        $this->num_cat =  $this->Categorias->num_rows;

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
                        <h3 class="mb-0">Elegir categoría</h3>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentController']; ?>_Controller.php?action=ADD">
                    <h6 class="heading-small text-muted mb-4"></h6>

                    <input type="hidden" name="campeonato_id" id="input-id" value="<?=$this->campeonato_id?>" class="form-control form-control-alternative">
                    <input type="hidden" name="pareja_id" readonly value="<?= $this->pareja_id?>">

                    <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="input-camp_cat_id">Categoría <br> (Nivel - Genero)</label>
                            <?php if($this->num_cat == 0){?>
                                <p> No hay más categorías disponibles en las que se pueda incribir </p>
                            <?php }else{ ?>
                                <select readonly class="browser-default custom-select" name="camp_cat_id" id="input-camp_cat_id" >
                                <?php
                                    foreach($this->Categorias as $row) { ?>
                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['nivel'].' - '.$row['genero']?></option>
                                <?php } ?>
                                </select>
                                <?php } ?>
                           
                        </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    <button class="btn btn-icon btn-3 btn-success" type="submit" > 
                        <span class="btn-inner--text">Enviar</span>
                    </button>
                    <a href="../Controllers/CAMPEONATO_Controller.php">
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
