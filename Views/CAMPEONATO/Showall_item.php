<?php

    

    class Showall_item {

        private $item;

        function __construct($item, $labels){
            
            $this->labels = $labels;
            $this->item = $item;
            $this->pinta();
        }

    function pinta(){        

        ?>
            <tr>
                <?php 
                foreach($this->labels as $key=>$value) {
                    if( $key != 0 ){
                        if($key == 2){ 
                            $fecha = explode("-", $this->item[$value]);
                            ?>
                            <td><?php echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                    <?php }
                        else{ ?>
                            <td>
                                <?php echo $this->item[$value]; ?> 
                            </td>
                <?php
                        }
                    } 
                }
                ?>
                <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ ?>
                    <td class="text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(32px, 32px, 0px);">
                                <a class="dropdown-item" href="../Controllers/INSCRIPCION_Controller.php?action=ADD_PAREJA&campeonato_id=<?php echo $this->item[$_SESSION['currentKey']]; ?>" >Inscribirse</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalDelete" data-whatever="<?php echo $this->item[$_SESSION['currentKey']]; ?>">Eliminar</a>
                                
                            </div>
                        </div>
                    </td>
                <?php }else { ?>
                    <td class="text-right">
                        <a href="../Controllers/INSCRIPCION_Controller.php?action=ADD_PAREJA&campeonato_id=<?php echo $this->item[$_SESSION['currentKey']]; ?>">
                            <div class="btn btn-icon btn-outline-secondary" style="margin-top: 1%; margin-bottom: 2.5%;">
                                <span class="btn-inner--text">Inscribirse</span>
                            </div>
                        </a>
                    </td>
                <?php } ?>
                <!--td class="text-right">
                    <div class="dropdown">
                        <button class="btn btn-icon btn-2  btn-outline-danger  btn-sm" type="button">
                            <a class="dropdown-item" href="#" data-toggle="modal" style="background-color: transparent;" data-target="#ModalDelete" data-whatever="<?php echo $this->item[$_SESSION['currentKey']]; ?>">
                                <span class="btn-inner--icon" style="background-color: transparent;"><i class="fas fa-trash"></i></span>
                            </a>
                        </button>
                    </div>
                </td-->
            </tr>


        <?php
        }
    }
?>