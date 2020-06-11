<?php

    class Header {

        function __construct(){

            $this->pinta();
        }

        function pinta(){

        ?>
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta http-equiv="X-UA-Compatible" content="ie=edge">
                    <title>SMASH PADEL</title>
                    
                    <script src="../Views/js/plugins/jquery/dist/jquery.min.js"></script>
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
                    <link href="../Views/css/argon-dashboard.min.css" rel="stylesheet">
                    <link href="../Views/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
                    <link href="../Views/js/plugins/@fortawesome/fontawesome-free/css/font-awesome.min.css" rel="stylesheet">
                    <link href="../Views/js/plugins/nucleo/css/nucleo.css" rel="stylesheet">
                    <link href="../Views/css/style.css" rel="stylesheet">
                    <script src="../Views/js/select.js"></script>
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>         
                    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.css"/>
                    <link rel="stylesheet" type="text/css" href="../Views/css/bootstrap-clockpicker.min.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha256-siyOpF/pBWUPgIcQi17TLBkjvNgNQArcmwJB8YvkAgg=" crossorigin="anonymous" />                
                    </head>   
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha256-bqVeqGdJ7h/lYPq6xrPv/YGzMEb6dNxlfiTUHSgRCp8=" crossorigin="anonymous"></script>
                  
           	 </head>
	    <body class="">
                
            <?php new Aside(); ?>
            
            <div class="main-content">
                <nav class="navbar navbar-top navbar-expand-md navbar-dark">
                    <div class="container-fluid">
                        <!-- Brand -->
                        <h1 class="mb-0 text-white text-uppercase d-none d-lg-inline-block mt-5" >  </h1>
                        
                        
                        <!-- User -->
                        <!--ul class="navbar-nav align-items-center d-none d-md-flex">
                            <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="media align-items-center">
                                        
                                        <div class="media-body ml-2 d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold"><?php echo $_SESSION['login']; ?></span>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                                    <div class=" dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Bienvenido!</h6>
                                        <h6><?php echo $_SESSION['login']; ?></h6>
                                    </div>
                                <a href="../Functions/Disconnect.php" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>Logout</span>
                                </a>                                
                            </li>
                        </ul-->
                    </div>
                </nav>
                <div class="header backgound_vistas pb-8 pt-5 pt-md-8">
                    
                    </div>
                    <div class="container-fluid mt--7">
                    
                        <div class="row mt-5">
                            <div class="col mb-5 mb-xl-0">

        <?php
        }
    }
?>
