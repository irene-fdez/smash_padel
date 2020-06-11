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
                <?php foreach($this->labels as $key=>$value) {
                    if($_SESSION['currentEntity'] != 'Usuario'){
                        if( $key != 0 ){
                ?>
                        <td>
                            <?php echo $this->item[$value]; ?> 
                        </td>
                <?php
                        } 
                    }else{
                ?>
                        <td>
                            <?php echo $this->item[$value]; ?> 
                        </td>
                <?php
                    } 
                }?>
                <td class="text-right">
                    <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(32px, 32px, 0px);">
                            <a class="dropdown-item" href="../Controllers/<?php echo $_SESSION['currentController']; ?>_Controller.php?action=SHOWCURRENT&<?php echo $_SESSION['currentKey']; ?>=<?php echo $this->item[$_SESSION['currentKey']]; ?>" >Ver</a>
                            <?php if( $_SESSION['currentEntity'] == 'Usuario'){ ?>
                                <a class="dropdown-item" href="../Controllers/<?php echo $_SESSION['currentController']; ?>_Controller.php?action=EDIT&<?php echo $_SESSION['currentKey']; ?>=<?php echo $this->item[$_SESSION['currentKey']]; ?>">Editar</a>
                            <?php } ?>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalDelete" data-whatever="<?php echo $this->item[$_SESSION['currentKey']]; ?>">Eliminar</a>
                            
                        </div>
                    </div>
                </td>
            </tr>


        <?php
        }
    }
?>