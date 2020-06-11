<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/Template/Showall_item.php';

    class Index {

        function __construct(){
            $this->pinta();
        }

    function pinta(){        

        ?>
            
            <?php new Header(); ?>
            <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                <h3 class="mb-0">Bienvenido a SMASH PADEL</h3>
                </div>
              </div>
            </div>
            <div class="card-body">
                <h6 class="heading-small text-muted mb-4">Página de Inicio</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="form-group">
                                <p style="font-size: 30px;">Selecciona la gestión que desees en el menú.</p>
                            </div>
                        </div>
                    </div>
                 </div>
                  </div>
                </div>
            </div>
          </div>
                <!-- Footer -->
                <?php new Footer(array()); ?>
        <?php
    
        }
    }
?>