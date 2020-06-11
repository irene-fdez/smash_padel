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
                    if($key != 0  && $key != 2  ){
                    ?>
                        <?php if($key == 3 || $key == 4){ ?>
                            <td <?php if($this->item['fecha'] < date('Y-m-d') || (!checFullTime($this->item['fecha'], $this->item['Hora inicio']))){ ?> style="color: #adb5bd" <?php } ?>><?php echo substr($this->item[$value], 0, 5); ?></td>
                        <?php }
                        elseif($key == 1){ 
                            $baja = 1; 
                            if(date('Y-m-d') > $this->item[$value]){  $baja = 0; }
                            
                            $fecha = explode("-", $this->item[$value]);
                            ?>
                            <td <?php if($this->item['fecha'] < date('Y-m-d') || (!checFullTime($this->item['fecha'], $this->item['Hora inicio']))){ ?> style="color: #adb5bd" <?php } ?>><?php echo $fecha[2]."/".$fecha[1]."/".$fecha[0] ?></td>
                        <?php }
                        else{ ?>
                            <?php $num_inscritos = $this->item[$value]; ?>
                            <td <?php if($this->item['fecha'] < date('Y-m-d') || (!checFullTime($this->item['fecha'], $this->item['Hora inicio']))){ ?> style="color: #adb5bd" <?php } ?>><?php echo $this->item[$value]; ?></td>
                        <?php } ?>
                <?php } 
                }?>
                <?php if($_SESSION['rol']['nombre'] == "Administrador"){ ?>
                    <?php if($this->item['fecha'] >= date('Y-m-d') && checFullTime($this->item['fecha'], $this->item['Hora inicio'])){?>
                        <td class="text-right">
                            <div class="dropdown">
                                
                                <button class="btn btn-icon btn-2  btn-outline-danger  btn-sm" type="button" style="text-align: center;">
                                    <a class="dropdown-item" href="#" data-toggle="modal" style="background-color: transparent;" data-target="#ModalDelete" data-whatever="<?php echo $this->item[$_SESSION['currentKey']]; ?>">
                                        <span class="btn-inner--icon" style="background-color: transparent;"><i class="fas fa-trash"></i></span>
                                    </a>
                                </button> 
                            
                            </div>
                        </td>
                    <?php }else{?>
                            <td></td>
                    <?php }
                    }else{ ?>
                    <td class="text-right">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(32px, 32px, 0px);">
                                <a class="dropdown-item" href="../Controllers/PARTIDO_Controller.php?action=SHOW_INSCRITOS_PARTIDO&<?php echo $_SESSION['currentKey']; ?>=<?php echo $this->item[$_SESSION['currentKey']]; ?>" >Ver inscritos</a>
                                <?php if($baja == 1 && $num_inscritos < 4){ ?>  
                                    <a class="dropdown-item" href="../Controllers/USUARIO_PARTIDO_Controller.php?action=DELETE&id_partido=<?php echo $this->item[$_SESSION['currentKey']]; ?>" >Darse de baja</a>
                                <?php } ?>
                            </div>
                        </div>
                    </td>
                <?php } ?>
            </tr>


        <?php
        }
    }

    function checFullTime($fecha, $hora_inicio){
        $ano = date("Y",strtotime($fecha));
		$mes = date("m",strtotime($fecha));
		$dia = date("d",strtotime($fecha));

        $hora_split = explode(':', $hora_inicio);
		$hora = $hora_split[0];
		$min = $hora_split[1];
		
		$fecha_obj = new DateTime(date('Y-m-d H:i:s', mktime($hora, $min, 0, $mes, $dia, $ano))); //fecha del recordset
        $fecha_hoy = new DateTime(date('Y-m-d H:i:s'));

        if($fecha_hoy>$fecha_obj){
            return false;
        } 
        return true;

    }
?>