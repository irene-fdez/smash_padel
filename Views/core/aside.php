<?php

    

    class Aside {

        function __construct(){

            $this->pinta();
        }

        function pinta(){

        ?>

            <nav class="navbar navbar-horizontal fixed-left navbar-expand-md navbar-dark bg-default" >
                <div class="container-fluid">
                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Brand -->
                <a class="navbar-brand pt-0" href="../Controllers/LOGIN_Controller.php">
                    <h1 style="color:white">SMASH PADEL</h1>
                </a>
                <ul class="navbar-brand ml-lg-auto mostrar_capa">
                        
                        <!-- User -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                
                                     <i class="fa fa-single"></i>
                                     <span class="mb-0 text-sm  font-weight-bold" style="color:white;text-transform:none;"><?php echo $_SESSION['login']; ?></span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Bienvenido!</h6>
                                    <h6><?php echo $_SESSION['login']; ?></h6>
                                </div>
                                <a href="../Functions/Disconnect.php" class="dropdown-item">
                                    <span style="text-transform:capitalize;">Desconectarse</span>
                                </a> 
                            </div>                               
                        </li>
                      
                    </ul>

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <!-- Collapse header -->
                    <div class="navbar-collapse-header d-md-none">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                
                                    
                                
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation -->
                    <ul class="navbar-nav ml-lg-auto">

                        <!-- submenú usuarios  (SOLO ADMIN) -->
                        <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ ?>

                            <li class="nav-item">
                                <a class="nav-link <?php if($_SESSION['currentEntity'] == 'Usuario') { echo 'active'; }  ?>" href="../Controllers/USUARIO_Controller.php">
                                    Usuarios
                                </a>
                            </li>

                        <?php } ?>


                         <!-- submenú partidos -->
                         <li  class="nav-item dropdown">
                            <a class="nav-link <?php if($_SESSION['currentEntity'] == 'Partido') { echo 'active'; }  ?>" href="#" id="navbar-default_dropdown_1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Partidos
                            </a>
                            <div  class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">

                            <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ //si es admin ?> 

                                <a class="dropdown-item" href="../Controllers/PARTIDO_Controller.php">Promocionar Partidos</a>
                                <a class="dropdown-item" href="../Controllers/PARTIDO_Controller.php?action=SHOWALL_PARTIDOS_INSCRIPCION">Inscripciones de Partidos</a>
                            
                                <?php } else{ //si es deportista ?>

                                <a class="dropdown-item" href="../Controllers/PARTIDO_Controller.php?action=INSCRIPCIONES_USER_PARTIDOS">Ver inscripciones</a>
                                <a class="dropdown-item" href="../Controllers/PARTIDO_Controller.php?action=INSCRIBIRSE_PARTIDO">Inscribirse</a>

                            <?php } ?>
                            </div>  
                        </li>
                           

                        <!-- submenú pistas (SOLO ADMIN) -->
                        <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ ?>

                            <li  class="nav-item dropdown">
                                <a class="nav-link <?php if($_SESSION['currentEntity'] == 'Pista') { echo 'active'; } ?>" href="#" id="navbar-default_dropdown_2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pistas
                                </a>
                                <div  class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_2">
                                    <a class="dropdown-item" href="../Controllers/PISTA_Controller.php"> Gestionar Pistas</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="../Controllers/HORARIO_Controller.php">Gestionar Horarios</a>
                                </div>  
                            </li>

                        <?php } ?>
                     

                        <!-- submenú reservas -->
                        <li  class="nav-item dropdown">
                            <a class="nav-link <?php if($_SESSION['currentEntity'] == 'Reserva') { echo 'active'; } ?>" href="#" id="navbar-default_dropdown_3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Reservas
                            </a>
                            <div  class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_3">
                                <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ ?>

                                    <a class="dropdown-item" href="../Controllers/RESERVA_Controller.php?action=SHOWALL_PISTAS_RESERVA"> Ver Reservas</a>
                               
                               <?php } else{ ?>

                                    <a class="dropdown-item" href="../Controllers/RESERVA_Controller.php?action=SHOWALL_PISTAS_RESERVA"> Tus Reservas</a>

                                <?php } ?>
                                <a class="dropdown-item" href="../Controllers/RESERVA_Controller.php">Reservar</a>
                            </div>  
                        </li>


                        <!-- submenú campeonatos -->
                        <li  class="nav-item dropdown">
                            <a class="nav-link <?php if($_SESSION['currentEntity'] == 'Campeonato') { echo 'active'; } ?>" href="#" id="navbar-default_dropdown_4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Campeonato
                            </a>
                            <div  class="dropleft dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_4">
                            
                                <a class="dropdown-item" href="#" id="navbar-default_dropdown_5" role="button" data-toggle="dropdown" aria-expanded="true">Gestionar Campeonatos</a>
                                <div  class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-default_dropdown_5" >

                                <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ //si es admin ?>

                                        <a class="dropdown-item" href="../Controllers/CAMPEONATO_Controller.php?action=ADD">Crear campeonato</a>
                                        <a class="dropdown-item" href="../Controllers/CAMPEONATO_Controller.php?action=CAMPEONATOS_CERRADOS">Campeonatos cerrados</a>
                                
                                <?php } else{ //si es deportista ?>

                                        <a class="dropdown-item" href="../Controllers/CAMPEONATO_Controller.php?action=CAMPEONATOS_USUARIO">Tus campeonatos</a>

                                <?php } ?>

                                    <a class="dropdown-item" href="../Controllers/CAMPEONATO_Controller.php">Campeonatos abiertos</a>

                                </div>
                                <div class="dropdown-divider"></div>

                                <?php if($_SESSION['rol']['nombre'] == 'Administrador'){ //si es admin ?>

                                    <a class="dropdown-item" href="../Controllers/ENFRENTAMIENTO_Controller.php">Gestionar Enfrentamientos</a>

                                <?php }else{ ?>

                                    <a class="dropdown-item" href="../Controllers/ENFRENTAMIENTO_Controller.php"> Gestionar Enfrentamientos</a>
                                    <a class="dropdown-item" href="../Controllers/ENFRENTAMIENTO_Controller.php?action=GESTION_HORARIO"> Gestionar Horario</a>
                               
                                    <?php } ?>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../Controllers/CLASIFICACION_Controller.php">Ranking</a>
                            </div>  
                        </li>


                    </ul>
                    <ul  class="navbar-nav ml-lg-auto ocultar_capa">
                        
                        <!-- User -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                
                                     <i class="fa fa-single"></i><span class="mb-0 text-sm  font-weight-bold"><?php echo $_SESSION['login']; ?></span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Bienvenido!</h6>
                                    <h6><?php echo $_SESSION['login']; ?></h6>
                                </div>
                                <a href="../Functions/Disconnect.php" class="dropdown-item">
                                    <span>Desconectarse</span>
                                </a> 
                            </div>                               
                        </li>
                    </ul>
                    <!--hr class="my-3">
                    <h6 class="navbar-heading text-muted">Control de acceso</h6>
                    <ul class="navbar-nav mb-md-3">
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SESSION['currentEntity'] == 'Rol') { echo 'active'; }  ?>" href="../Controllers/ROL_Controller.php">
                            <i class="ni ni-spaceship"></i> Rol
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SESSION['currentEntity'] == 'Funcionalidad') { echo 'active'; }  ?>" href="../Controllers/Funcionalidad_Controller.php">
                            <i class="ni ni-palette"></i> Funcionalidad
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($_SESSION['currentEntity'] == 'Accion') { echo 'active'; }  ?>" href="../Controllers/Accion_Controller.php">
                            <i class="ni ni-ui-04"></i> Acción
                            </a>
                        </li>
                    </ul-->
                
                </div>
            </nav>
        <?php
        }
    }
?>