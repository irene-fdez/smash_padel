<?php

    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/core/aside.php';

    class Add_horario {

       function __construct($data, $edit){
          $this->horario = $data;
          
          $this->edit = $edit;
          if ($this->edit) {
              $this->data = $data["edit"];
          }
        

          $this->pinta();
      }

    function pinta(){        

        ?>
            <?php new Header(); ?>

            <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                <?php if($this->edit) { ?>
                  <h3 class="mb-0">Editar horario</h3>
                <?php }else{ ?>
                  <h3 class="mb-0">Añadir rango de horario</h3>
                <?php } ?>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentEntity'];?>_Controller.php?action=<?php if($this->edit) { echo 'EDIT'; } else { echo 'ADD'; } ?>">
                <h6 class="heading-small text-muted mb-4">Rangos de horario disponibles</h6>
                <div class="pl-lg-4">

                    <div class="row">
                        

                        <div class="col-lg-6">
                        <div class="form-group focused">
                            <label class="form-control-label" for="input-horario">Horario</label>
                            <select class="browser-default custom-select js-example-basic-single" name="horario" id="horario">
                            <?php
                                foreach($this->horario as $key => $value) { ?>
                                  <option value="<?= $key ?>"><?php echo substr($key, 0, 5), " - ", substr($value, 0, 5)?></option>
                            <?php } ?>
                            </select>
                            <!-- meter js para coger el valor seleccionado en el select>
                            <input class="oculto" name="hora_inicio" readonly value="<?=$key?>">
										        <input class="oculto" name="hora_fin" readonly value="<?=$value?>" -->         
                           
                        </div>
                        </div>

                    </div>


                <hr class="my-4">
                <button class="btn btn-icon btn-3 btn-success" type="submit">
                    <span class="btn-inner--text">Enviar</span>
                </button>
                <a href="../Controllers/<?php echo $_SESSION['currentEntity']?>_Controller.php">
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