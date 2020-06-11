<?php

    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/core/aside.php';

    class Add {

        function __construct($data, $col_names, $edit){
          
          
            $this->data = $data;
            $this->col_names = $col_names;
            $this->edit = $edit;
            $this->pinta();
        }

    function pinta(){        

        ?>
            <?php new Header(); ?>

            <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Nuev@ <?php echo $_SESSION['currentEntity'];?></h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentEntity'];?>_Controller.php?action=<?php if($this->edit) { echo 'EDIT'; } else { echo 'ADD'; } ?>">
                <h6 class="heading-small text-muted mb-4"><?php echo $_SESSION['currentEntity'];?> information</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-email">Nombre Accion</label>
                                <input type="text" name="nombre" required id="input-email" value="<?php if($this->edit) { echo $this->data['nombre']; } ?>" class="form-control form-control-alternative" >
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="input-username">Descripcion Accion</label>
                                <input type="text" name="descripcion" required id="input-username" value="<?php if($this->edit) { echo $this->data['descripcion']; } ?>" class="form-control form-control-alternative"  >
                            </div>
                        </div>
                        <input type="hidden" name="id" required id="input-username" value="<?php if($this->edit) { echo $this->data['id']; } ?>" class="form-control form-control-alternative" >
                    </div>
                </div>
                <hr class="my-4">
                <button class="btn btn-icon btn-3 btn-primary" type="submit">
                    <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                    <span class="btn-inner--text">Enviar</span>
                </button>
                <a href="../Controllers/<?php echo $_SESSION['currentEntity']?>_Controller.php">
                  <div class="btn btn-icon btn-3 btn-primary">
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