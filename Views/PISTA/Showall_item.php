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
                <?php foreach($this->labels as $key=>$value) { ?>
                    <td>
                        <?php echo $this->item[$value]; ?> 
                    </td>
                <?php } ?>
                <td class="text-right">
                    <div class="dropdown">
                        <button class="btn btn-icon btn-2  btn-outline-danger  btn-sm" type="button">
                            <a class="dropdown-item" href="#" data-toggle="modal" style="background-color: transparent;" data-target="#ModalDelete" data-whatever="<?php echo $this->item[$_SESSION['currentKey']]; ?>">
                                <span class="btn-inner--icon" style="background-color: transparent;"><i class="fas fa-trash"></i></span>
                            </a>
                        </button>
                    </div>
                </td>
            </tr>


        <?php
        }
    }
?>