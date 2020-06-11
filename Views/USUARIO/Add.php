<?php

    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/core/aside.php';

    class Add {

       function __construct($data, $edit){
          $this->roles = $data[0];
          $this->edit = $edit;
          
          if($this->edit) {
            $this->data = $data[1];
            $this->role = $data[2];
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
                  <h3 class="mb-0">Editar usuario</h3>
                <?php }else{ ?>
                  <h3 class="mb-0">Añadir usuario</h3>
                <?php } ?>
                </div>
              </div>
            </div>
            <div class="card-body">
              <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/<?php echo $_SESSION['currentEntity'];?>_Controller.php?action=<?php if($this->edit) { echo 'EDIT'; } else { echo 'ADD'; } ?>">
                <h6 class="heading-small text-muted mb-4">Informacion de usuario</h6>
                <div class="pl-lg-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="form-control-label" for="input-login">Login</label>
                                <input type="text" name="login" required id="input-login" value="<?php if($this->edit) { echo $this->data['login']; } ?>" class="form-control form-control-alternative" placeholder="Login" <?php if($this->edit) {?> readonly <?php } ?>>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group focused">
                            <?php if($this->edit) {?>
                                <label class="form-control-label" for="input-contrasena2">Nueva contraseña (Opcional)</label>
                                <input type="password" name="password2" id="input-contrasena2" value="" class="form-control form-control-alternative" placeholder="Introduzca la nueva contraseña">
                             <?php }else{ ?>
                                <label class="form-control-label" for="input-contrasena">Contraseña</label>
                                <input type="password" name="password" required id="input-contrasena" value="" class="form-control form-control-alternative" placeholder="Contraseña">
                             <?php } ?>
                            </div>
                        </div>
                    </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-nombre">Nombre</label>
                        <input type="text" name="nombre" required id="input-nombre" value="<?php if($this->edit) { echo $this->data['nombre']; } ?>" class="form-control form-control-alternative" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-apellidos">Apellidos</label>
                        <input type="text" name="apellidos" required id="input-apellidos" value="<?php if($this->edit) { echo $this->data['apellidos']; } ?>" class="form-control form-control-alternative" placeholder="Apellidos">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-genero">Genero</label>
                        <select class="browser-default custom-select" name="genero" id="input-genero">
                            <option value='Masculino'>Masculino</option>
                            <option value='Femenino'>Femenino</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group focused">
                        <label class="form-control-label" for="input-email">Email</label>
                        <input type="email" name="email" required id="input-email" value="<?php if($this->edit) { echo $this->data['email']; } ?>" class="form-control form-control-alternative" placeholder="jesse@email.com">
                      </div>
                    </div>
                  </div>

                <div class="table-responsive">
                  <div class="pl-lg-4">
                  <label class="form-control-label" for="input-last-name">Rol</label>
                    <table class="table align-items-center table-flush">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                      <tr>
                        <?php
                          $i=0;
                                  
                            foreach($this->roles as $row) { ?>
                              <td class="text-center" >
                                <div class="custom-control custom-radio mb-3">
                                  <input 
                                  <?php 
                                    if($this->edit){
                                      foreach($this->role as $rol) {
                                        if($rol['ROL_id'] == $row['id'])
                                          echo 'checked ';
                                      }
                                    }
                                    ?>
                                     class="custom-control-input" name="rol" id="<?php echo $row['id']; ?>" value="<?php echo $row['id']; ?>" type="radio">
                                  <label class="custom-control-label" for="<?php echo $row['id']; ?>"> 
                                  <?php echo $row['nombre']; ?>
                                  </label>
                                </div>
                              </td> 
                            <?php 
                            $i++;

                            if($i == 2){
                              ?> </tr><tr> <?php
                            }
                          } ?>
                      </tr>
                    </table>
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