<?php

include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/core/aside.php';

class Add
{
    var $data;

    function __construct($data, $edit)
    {
        $this->Pistas = $data;
        $this->edit = $edit;
        if ($this->edit){ $this->data = $data["edit"];}
        
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
                            <h3 class="mb-0">Editar pista</h3>
                        <?php } else { ?>
                            <h3 class="mb-0">Añadir pista</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form role="form" enctype="multipart/form-data" method="post"
                      action="../Controllers/<?php echo $_SESSION['currentController']; ?>_Controller.php?action=<?php if ($this->edit) {
                          echo 'EDIT';
                      } else {
                          echo 'ADD';
                      } ?>">
                    <h6 class="heading-small text-muted mb-4">Información de la pista</h6>
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
                                       } ?>" class="form-control form-control-alternative" pattern="[A-Za-z0-9ñÑçÇ ]+"
                                       placeholder="Nombre de la pista">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="input-tipo">Tipo</label>
                                <input type="text" name="tipo" required id="input-tipo"
                                       value="<?php if ($this->edit) {
                                           echo $this->data['tipo'];
                                       } ?>" class="form-control form-control-alternative"
                                       placeholder="Tipo de pista" pattern="[A-Za-z0-9ñÑçÇ-, ]+">
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    <button class="btn btn-icon btn-3 btn-success" type="submit">
                        <span class="btn-inner--text">Enviar</span>
                    </button>
                    <a href="../Controllers/<?php echo $_SESSION['currentController'] ?>_Controller.php">
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
