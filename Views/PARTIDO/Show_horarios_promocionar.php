<?php

include_once '../Functions/Authentication.php';
include_once '../Views/core/aside.php';
include_once '../Views/core/header.php';
include_once '../Views/core/footer.php';
include_once '../Views/HORARIO/Showall_item.php';


class Show_horarios_promocionar {

    var $horariosList;
	var $reservasList;
	var $pistasList;
	var $reservasPistaList;
	var $horarios;
	var $reservas;
    var $pistas;
    var $pistas_disponibles;

    function __construct($horarios, $reservas, $pistas){

        $this->horarios = $horarios;
		$this->reservas = $reservas;
		$this->pistas = $pistas;

        $this->dias_semana = array(
            "1" => array( date("l"), date("d/m/Y") ),
            "2" => array( date("l",strtotime("+1 day")), date("d/m/Y",strtotime("+1 day")) ),
            "3" => array( date("l",strtotime("+2 day")), date("d/m/Y",strtotime("+2 day")) ),
            "4" => array( date("l",strtotime("+3 day")), date("d/m/Y",strtotime("+3 day")) ),
            "5" => array( date("l",strtotime("+4 day")), date("d/m/Y",strtotime("+4 day")) ),
            "6" => array( date("l",strtotime("+5 day")), date("d/m/Y",strtotime("+5 day")) ),
            "7" => array( date("l",strtotime("+6 day")), date("d/m/Y",strtotime("+6 day")) ),
        );

        $this->reservasPistaList;
		$this->horariosList;
		$this->reservasList;
        $this->pistasList;
        $this->pistas_disponibles;
		$this->rellenarListas();
		$this->pinta();
    }

function pinta(){        
    include './../Locales/Strings_SPANISH.php';

    ?>
        
        <?php new Header(); ?>            
                    <div class="card shadow">
                    
                        <div class="card-header bg-secondary border-0">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Horarios disponibles</h3>
                                </div>
                                <div class="col text-right">
                                    <!--a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=SEARCH" class="btn btn-sm btn-success">Buscar</a-->
                                    <!--a href="../Controllers/<?php echo $_SESSION['currentController']?>_Controller.php?action=ADD" class="btn btn-sm btn-success">Añadir</a-->
                                </div>
                            </div>
                            <h6 class="heading-small text-muted mb-4" style="height: 10px"></h6>
                        </div>

                        <div class="card-body">
                        <div class="table-responsive">
                            <!-- Projects table -->
                            <table class="table align-items-center table-flush" >
                                <thead class="thead-light">
                                    <tr>
                                        
                                        <?php  
                                        if($this->horariosList <> NULL && $this->pistasList <> NULL){
                                         //echo $strings[$this->dias_semana[1][0]];
                                         //echo '<br>'.$this->dias_semana[1][1] ;
                                        for($i = 1; $i <= 7 ; $i++) { ?>

                                            <th scope="col" style="text-align: center;"><?= $strings[$this->dias_semana[$i][0]], '<br> ' , $this->dias_semana[$i][1] ?></th>

                                        <?php   } ?>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php
							foreach ($this->horariosList as $key => $value) { //se colocan todos los horarios
						?>
								<tr>
							<?php
								
								for($i = 1; $i <= 7; $i++){
									if($this->hay_Reserva($key, $i-1) == true){ //si esta reservadoe 
								?>
                                        <td style="text-align: center;">
                                            <a>
                                                <div class="btn btn-icon btn btn-outline-danger disabled" style="margin-top: 1%">
                                                    <span class="btn-inner--text"><?=$value?></span>
                                                </div>
                                            </a> 
                                            <!--a class="button alt small"><?=$value?></a-->
                                         </td>
									<?php
                                    }
                                    else {
                                        //si esta disponible 
                                    ?>     
                                        <td style="text-align:center;">
                                        <?php  if( ($this->dias_semana[$i][1] == $this->dias_semana[1][1] ) && strtotime(date("H:i")) > strtotime( $value )  ) {?>

                                            <a>
                                            <div class="btn btn-icon btn btn-outline-secondary disabled"  style="margin-top: 1%;color: gray">

                                        <?php  }elseif( $this->pistas_disponibles  == 1 ) { ?>
                                            
                                            <a href="../Controllers/<?=$_SESSION['currentController']?>_Controller.php?action=ADD&fecha=<?=$this->dias_semana[$i][1]?>&horario=<?=$key?>">
                                            <div class="btn btn-icon btn btn-outline-primary" title="Ultima reserva" style="margin-top: 1%">

                                        <?php  }else{ ?>

                                            <a href="../Controllers/<?=$_SESSION['currentController']?>_Controller.php?action=ADD&fecha=<?=$this->dias_semana[$i][1]?>&horario=<?=$key?>">
                                            <div class="btn btn-icon btn btn-outline-success" style="margin-top: 1%">
                                        <?php } ?>

                                                <span class="btn-inner--text"><?=$value?></span>
                                            </div>
                                        </a>    
                                        <!--a href="../Controllers/<?=$_SESSION['currentController']?>_Controller.php?action=ADD&fecha=<?=$this->dias_semana[$i][1]?>&horario=<?=$key?>" class="button small"><?=$value?></a-->
                                    
                                        </td>
								<?php
										} //fin else
									}//fin for
							?>
								</tr>
						<?php
							}//fin foreach
						}//fin del if
						else{
							if($this->horariosList == NULL){
						?>
	    					<p>No hay horarios disponibles</p>
						<?php
							}else{
						?>
	    					<p>No hay pistas disponibles</p>
						<?php
							}
						}//fin del else
					?>
                                       
                                </tbody>
                            </table>
                        </div>
                        <hr class="my-4">
                        <a href="../Controllers/LOGIN_Controller.php">
                            <div class="btn btn-icon btn-default" style="margin-top: 1%; margin-bottom: 2.5%;">
                                <span class="btn-inner--text">Atras</span>
                            </div>
                        </a>    
                        </div>
                    </div>             
                   
                
            <!-- Footer -->
            <?php new Footer(array()); ?>
    <?php

    }

    /*
        Funcion que alacena en listas las tuplas resultantes del modelo de datos
    */
    function rellenarListas(){
        if($this->horarios <> NULL){ //si existen horarios
            while($row = mysqli_fetch_array($this->horarios)){
                $this->horariosList[$row["id"]] =  substr($row["hora_inicio"], 0, 5); 
            }
        }
        if($this->reservas <> NULL){//si existen reservas
            $i = 0;
            while($row = mysqli_fetch_array($this->reservas)){
                $this->reservasList[$row["id"]] = array( $row["fecha"],$row["HORARIO_id"], $row["PISTA_nombre"]);
                $this->reservasPistaList[$row["fecha"]][$row["HORARIO_id"]][$i] = $row["PISTA_nombre"];//lista para contar el numero de pistas usadas en funcion de la fecha y horario
                $i++;
            }
        }

        if($this->pistas <> NULL){//si existen pistas
            while($row = mysqli_fetch_array($this->pistas)){ //se recorren las pistas y almacenan en un array
                $this->pistasList[$row["nombre"]] = $row["tipo"];
            }
        }

    } // fin del metodo rellenarListas

    /*
    Comprueba si una franja horaria si ya existe una reserva
    Retorna true si esta disponible y false si no lo esta
    */
    function hay_Reserva($horario_id, $day){ 
        $fecha = new DateTime(date('Y-m-d' , strtotime("+".$day." day"))); //Se crea un objeto DateTime con la fecha que se pase como parametro
        if($this->reservasList <> NULL){
            $this->pistas_disponibles = count($this->pistasList);

            foreach ($this->reservasList as $key => $reserva) { //se recorren las reservas
                $fecha_aux = new DateTime( $reserva[0] ); //se coge la fecha de cada reserva
                $diff = date_diff($fecha,$fecha_aux); //se compara la fech introducida como parametro y la recuperada de la lista
                
                if (($horario_id == $reserva[1]) && ( $diff->format("%d") == 0) ) { //si coincide el horario y la diferencia entre fechas es 0

                    if(( count($this->pistasList) - count($this->reservasPistaList[$reserva[0]][$reserva[1]])) == 1 ){
                        $this->pistas_disponibles = 1;
                    }

                    if(count($this->reservasPistaList[$reserva[0]][$reserva[1]])
                        == count($this->pistasList) ){ //si el numero de reservas de una fecha y un horario es igual al numero de pistas del club
      
                        return true;
                    }
                }
            }//fin del foreach
            return false;
        }else{
            return false;
        }
    }//fin del metodo hayReservas
 


}
?>