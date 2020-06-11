<?php

    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/core/aside.php';

    class Search {
        
        function __construct($col_names){
            $this->col_names = $col_names;
            $this->pinta();
        }

    function pinta(){        

        ?>
            <?php new Header(); ?>

            <div class="card bg-secondary shadow">
            <div class="card-header bg-white border-0">
              <div class="row align-items-center">
                <div class="col-8">
                  <h3 class="mb-0">Buscar <?php echo $_SESSION['currentEntity'];?></h3>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentEntity'];?>_Controller.php?action=SEARCH">
                <h6 class="heading-small text-muted mb-4">Filtro de <?php echo $_SESSION['currentEntity'];?></h6>
                <input type="hidden" name="id" id="input-id" value="" class="form-control form-control-alternative">
                <?php 
                  $i = 0;
                  foreach($this->col_names as $col_key=>$col_value) { 
                    if ($i % 2 == 0) {
                      ?> 
                        <div class="row">
                      <?php 
                    }
                ?>

                  <div class="col-lg-6">
                    <div class="form-group focused">
                      <label class="form-control-label" for="input-nombre"><?php echo $col_value;?></label>
                      <input type="text" name="<?php echo $col_key; ?>" id="input-nombre" value="" class="form-control form-control-alternative" placeholder="">
                    </div>
                  </div>
                  
                <?php 
                    if ($i % 2 == 1) {
                      ?> 
                        </div>
                      <?php 
                    }         
                    $i++;
                  } 

                  if ($i % 2 == 1) {
                    ?> 
                      </div>
                    <?php 
                  }
                ?> 
                
                  
                
                <input type="hidden" name="borrado" required id="input-borrado" value="<?php echo 0; ?>" class="form-control form-control-alternative">
                <hr class="my-4">
                <button class="btn btn-icon btn-3 btn-primary" type="submit">
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