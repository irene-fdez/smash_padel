<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Add_campeonato
{
    var $data;

    function __construct($data, $edit)
    {
        $this->categorias = $data[0];
        $this->edit = $edit;
        if ($this->edit) {
            $this->data = $data["edit"];
        }

        $this->fecha_actual = date("m/d/Y");

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
                        <?php if ($this->edit) { ?>
                            <h3 class="mb-0">Editar campeonato</h3>
                        <?php } else { ?>
                            <h3 class="mb-0">Añadir campeonato</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form role="form" enctype="multipart/form-data" method="post" autocomplete="off"
                      action="../Controllers/<?= $_SESSION['currentController']; ?>_Controller.php?action=<?php if ($this->edit) {
                          echo 'EDIT';
                      } else {
                          echo 'ADD';
                      } ?>">
                    <h6 class="heading-small text-muted mb-4">Información del campeonato</h6>
                    <input type="hidden" name="id" id="input-id" value="<?php if ($this->edit) {
                        echo $this->data['id'];
                    } else {
                        echo 'NULL';
                    } ?>" class="form-control form-control-alternative">
                    <div class="row">
                    
                        <div class="col-lg-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="input-nombre">Nombre</label>
                                <input type="text" name="nombre" required id="input-nombre"
                                       value="<?php if ($this->edit) {
                                           echo $this->data['nombre'];
                                       } ?>" class="form-control form-control-alternative" pattern="[A-Za-z0-9ñÑçÇ- ]+"
                                       placeholder="Nombre">
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <label class="form-control-label" for="input-fecha">Fecha</label>
                            <div class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                    </div>
                                    <input class="form-control datepicker" type="text" placeholder="Seleccione fecha" value="<?=$this->fecha_actual?>" name="fecha" >
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <label class="form-control-label" for="input-last-name">Categoría/s (Nivel-Genero)</label>
                        <div class="mb-6 col-xl-12" style="margin-right: 5%;" >
                        <?php 
                            $count = 0;
                            foreach($this->categorias as $row){
                        ?>      
                                <div class="custom-control custom-checkbox" style="display: inline-block; margin-right: 5%; width: 20%;">
                                    <input class="custom-control-input" id="<?= $row['id'] ?>" type="checkbox"  name="categorias[]" value="<?= $row['id'] ?>">
                                    <label class="custom-control-label"  for="<?= $row['id'] ?>" style="margin-right: 20%;  "><?= $row['nivel']." - ".$row['genero']?></label>
                                   
                                </div>
                                <?php if($count == 2 || $count == 5){ ?> <br> <?php } ?>
                        <?php
                                $count +=1;
                                
                            }
                        ?>
                        </div>
                   
                    
                    <hr class="my-4">
                    <button class="btn btn-icon btn-3 btn-success" type="submit">
                        <span class="btn-inner--text">Enviar</span>
                    </button>
                    <a href="../Controllers/<?= $_SESSION['currentController'] ?>_Controller.php">
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
