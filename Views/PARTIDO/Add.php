<?php

    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/core/aside.php';

    class Add {

       function __construct($data, $edit, $horarios){
          $this->partido = $data;
          
          $this->edit = $edit;
          if ($this->edit) {
              $this->data = $data["edit"];
          }
          $this->horarios = $horarios;

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
                  <h3 class="mb-0">Editar partido</h3>
                <?php }else{ ?>
                  <h3 class="mb-0">Añadir partido</h3>
                <?php } ?>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentEntity'];?>_Controller.php?action=<?php if($this->edit) { echo 'EDIT'; } else { echo 'ADD'; } ?>">
                <h6 class="heading-small text-muted mb-4">Informacion de partido</h6>
                <div class="pl-lg-4">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group date" data-provide="datepicker">
                            <?php 
                            if ($this->edit){ 
                            ?>
                                <label class="form-control-label" for="input-fecha">Fecha</label>
                                <input type="text" class="form-control" name="fecha" value="<?php echo $this->data['fecha']; ?>">
                            <?php 
                            }
                            else
                            { ?>
                                <label class="form-control-label" for="input-fecha">Fecha </label>
                                <input type="text" class="form-control" name="fecha">
                            <?php 
                            } 
                            ?>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group focused">
                              <label class="form-control-label" for="input-horario">Horario</label>
                              <select class="browser-default custom-select js-example-basic-single" name="horario" id="horario">
                              <?php
                                  foreach($this->horarios as $row) { ?>
                                  
                                  <option <?php if($this->edit) { if($this->data['horario']==$row['id']) { echo "selected"; } } ?> value="<?php echo $row['id']; ?>"><?php echo $row['hora_inicio'], " - ", $row['hora_fin'] ?></option>
                              <?php } ?>
                              </select>
                          </div>
                        </div>

                    </div>


                  <!--div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-nombre">Usuario que promociona</label>
                        <input type="text" name="nombre" required id="input-nombre" value="<?php if($this->edit) { echo $this->data['USUARIO_login']; }else{ echo $_SESSION['login']; } ?>" class="form-control form-control-alternative" readonly>
                      </div>
                    </div>


                  </div-->


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