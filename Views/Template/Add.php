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
                                <label class="form-control-label" for="input-email">Email</label>
                                <input type="email" name="email" required id="input-email" value="<?php if($this->edit) { echo $this->data['email']; } ?>" class="form-control form-control-alternative" placeholder="jesse@example.com">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group focused">
                                <label class="form-control-label" for="input-username">Password</label>
                                <input type="password" name="password" required id="input-username" value="<?php if($this->edit) { echo $this->data['password']; } ?>" class="form-control form-control-alternative" placeholder="Username" value="lucky.jesse">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group focused">
                          <label class="form-control-label" for="input-first-name">Name</label>
                          <input type="text" name="name" required id="input-first-name" value="<?php if($this->edit) { echo $this->data['name']; } ?>" class="form-control form-control-alternative" placeholder="First name" value="Lucky">
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="form-group focused">
                          <label class="form-control-label" for="input-last-name">Surname</label>
                          <input type="text" name="surname" required id="input-last-name" value="<?php if($this->edit) { echo $this->data['surname']; } ?>" class="form-control form-control-alternative" placeholder="Last name" value="Jesse">
                        </div>
                      </div>
                    </div>
                </div>
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