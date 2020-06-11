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
            <tr style="height: 60px;">
                <?php foreach($this->labels as $key=>$value) {
                        if($key != 0  && $key != 5  ){
                        ?>
                            <td <?php if($this->item['fecha'] < date('Y-m-d') || (!checFullTime($this->item['fecha'], $this->item['Hora inicio']))){ ?> style="color: #adb5bd" <?php } ?> >
                                <?php echo $this->item[$value]; ?> 
                            </td>
                <?php   }
                    }
                    ?>
                
                <td class="text-center" style="width: 15%;">
                <?php if($this->item['fecha'] >= date('Y-m-d') && checFullTime($this->item['fecha'], $this->item['Hora inicio'])){?>
                        <div class="dropdown">
                            <?php
                                $eliminar_reserva = false;
                                $eliminar_reserva = checkFecha($this->item['fecha'], $this->item['Hora inicio']);

                                if($eliminar_reserva){
                            ?>
                                <button class="btn btn-icon btn-2  btn-outline-danger  btn-sm" type="button" style="text-align: center;">
                                    <a class="dropdown-item" href="#" data-toggle="modal" style="background-color: transparent;" data-target="#ModalDelete" data-whatever="<?php echo $this->item[$_SESSION['currentKey']]; ?>">
                                        <span class="btn-inner--icon" style="background-color: transparent;"><i class="fas fa-trash"></i></span>
                                    </a>
                                </button>       
                            <?php 
                                }else{
                            ?>
                                <button class="btn btn-outline-secondary  btn-sm" type="button" style="text-align: center;" disbled>
                                    <a class="dropdown-item" style="background-color: transparent;" >
                                        <span style="text-align: center;">Quedan menos de 12 horas</span>
                                    </a>
                                </button> 
                            <?php
                                }
                            ?>

                            
                        
                        </div>
                <?php } ?>    
                </td>
                
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


    function checkFecha($fecha, $hora_inicio){


		$ano = date("Y",strtotime($fecha));
		$mes = date("m",strtotime($fecha));
		$dia = date("d",strtotime($fecha));

        $hora_split = explode(':', $hora_inicio);
		$hora = $hora_split[0];
		$min = $hora_split[1];
		
		$fecha_obj = new DateTime(date('Y-m-d H:i:s', mktime($hora, $min, 0, $mes, $dia, $ano))); //fecha del recordset
		$fecha_hoy = new DateTime(date('Y-m-d H:i:s'));

		$diff_horas = $fecha_hoy->diff($fecha_obj); //diferencia entre fechas
        $out = $diff_horas->format("%d, %H, %i");   //dias-horas-minutos
        
		$split_dias = explode(',', $out);
		$dias = $split_dias[0];
		$horas = $split_dias[1];
		$minutos = $split_dias[2];

		if($dias > 0){
            return true;
		}else{
			if($horas >= 12){
				return true;
			}
             return false;
		}
	 return false;
	}
?>