<?php

    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/core/aside.php';
class MESSAGE{
    var $mensaje; // Almacena el mensaje enviado por el controlador
	var $msqli; //Almacena los datos de la coexión a la BD
	var $origen; //Almacena el origen de la orden
	var $resultado; // array para almacenar los datos del usuario
	
    function __construct($datos,$origen){
        $this->mensaje = $datos;
        $this->origen = $origen;
        $this->pinta();
    }

    function pinta(){        

        ?>
        <?php new Header(); ?>
        
        <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                <h3 class="mb-0">Mensaje del sistema</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <h6 class="heading-small text-muted mb-4">Información</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <p style="font-size: 30px;"><?php echo $this->mensaje ?></p>
                            </div>
                        </div>
                    </div>
                 </div>
                  </div>
                </div>
                <hr class="my-4">
                <button class="btn btn-icon btn-3 btn-default" type="submit">
                    <span class="btn-inner--icon"><i class=""></i></span>
                    <a href='<?php echo $this->origen?>' ><span style="color:white" class="btn-inner--text">Volver</span> </a>
                </button>
            </div>
          </div>



    <?php new Footer(array()); ?>
    <?php
    }
}
?>