<?php

    include_once '../Functions/Authentication.php';
    include_once '../Views/core/aside.php';
    include_once '../Views/core/header.php';
    include_once '../Views/core/footer.php';
    include_once '../Views/PISTA/Showall_item.php';

    class Add_reserva_pista {

        function __construct($pistas, $fecha, $horario){

            $this->pistas = $pistas;
		    $this->fecha = $fecha;
            $this->horario = $horario;
            $this->horario = mysqli_fetch_array($horario);
            
            $this->pinta();
        }

    function pinta(){        
        ?>
            <?php new Header(); ?>            
                        <div class="card shadow">
                        
                            <div class="card-header bg-secondary border-0">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h3 class="mb-0"><?php echo $_SESSION['currentEntity']?>r Pista </h3>
                                    </div>
                                    <div class="col text-right">
                                        <!--a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SEARCH" class="btn btn-sm btn-success">Buscar</a>
                                        <a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=ADD" class="btn btn-sm btn-success">Añadir</a-->
                                    </div>
                                </div>
                                <h6 class="heading-small text-muted mb-4" style="height: 10px">Día <?=$this->fecha?> de <?= substr($this->horario['hora_inicio'], 0, 5);?> a <?= substr($this->horario['hora_fin'], 0, 5);?> h</h6>
                            </div>

                            <div class="card-body">
                            <div class="table-responsive">
                                <!-- Projects table -->
                                <table class="table align-items-center table-flush" data-order='[[ 0, "asc" ]]' id='example'>
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nombre </th>
                                            <th>Tipo </th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($this->pistas != NULL) {
                                                foreach ($this->pistas as $key => $value){ ?>
                                                <!--form method="post" name='add_<?=$key?>' action="../Controllers/<?=$_SESSION['currentController']?>_Controller.php?action=ADD"-->
                                                    <tr>
                                                        <td> <?php echo $key; ?> </td>
                                                        <td> <?php echo $value; ?> </td>
                                                        <td class="text-right">
                                                            <a href="../Controllers/<?=$_SESSION['currentController']?>_Controller.php?action=ADD&id_horario=<?=$this->horario['id']?>&fecha=<?=$this->fecha?>&nombre_pista=<?=$key?>">
                                                                <div class="btn btn-icon btn-outline-success" style="margin-top: 1%; margin-bottom: 2.5%;">
                                                                    <span class="btn-inner--text">Reservar</span>
                                                                </div>
                                                            </a>
                                                        </td>
                                                    <?php  ?>
                                                        <!--td class="text-right">
                                                            <input style="display:none" name="id_horario" readonly value="<?=$this->horario['id']?>">
								                            <input style="display:none" name="fecha" readonly value="<?=$this->fecha?>">
                                                            <input style="display:none" name="nombre_pista" readonly value="<?=$key?>">

                                                            <button class="btn btn-icon btn-3 btn-outline-success" type="submit">
                                                                <span class="btn-inner--text">Reservar</span>
                                                            </button>
                                                        </td-->
                                                    </tr>
                                                <!--/form-->
                                            <?php  }          
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                            
                            <a href="../Controllers/<?=$_SESSION['currentController']?>_Controller.php">
                                <div class="btn btn-icon btn-default" style="margin-top: 1%">
                                    <span class="btn-inner--text">Atras</span>
                                </div>
                            </a>     
                            </div>
                        </div>            
                    
                <!-- Footer -->
                <?php new Footer(array()); ?>
        <?php
        }
    }
?>