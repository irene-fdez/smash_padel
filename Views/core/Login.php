<?php

    include_once '../Views/core/footer.php';

    class Login {
        var $msg;

        function __construct($msg = NULL){
            $this->msg = $msg;
            $this->pinta();
        }

    function pinta(){        

        ?>

            <html lang="en"><head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>
            SMASH PADEL 
            </title>
            <!-- Extra details for Live View on GitHub Pages -->
            <!-- Canonical SEO -->
            <link rel="canonical" href="https://www.creative-tim.com/product/argon-dashboard">

            <!-- Favicon -->
            <link href="../Views/img/brand/favicon.png" rel="icon" type="image/png">
            <!-- Fonts -->
            <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
            <!-- Icons -->
            <link href="../Views/js/plugins/nucleo/css/nucleo.css" rel="stylesheet">
            <link href="../Views/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
            <!-- CSS Files -->
            <link href="../Views/css/argon-dashboard.min.css?v=1.1.0" rel="stylesheet">
            <link href="../Views/css/style.css" rel="stylesheet">
            <!-- Google Tag Manager -->
            </head>
            
            <body style="background-color: #1E4AA0;">
                
                
                <div class="main-content">
                    <!-- Navbar -->
                    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
                    <div class="container px-4">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbar-collapse-main">
                        <!-- Collapse header -->
                        <div class="navbar-collapse-header d-md-none">
                            <div class="row">
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                                </button>
                            </div>
                            </div>
                        </div>
                        <!-- Navbar items -->
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link nav-link-icon" href="../Controllers/REGISTRO_Controller.php">
                                    <i class="ni ni-circle-08"></i>
                                    <span class="nav-link-inner--text">Registro</span>
                                </a>
                            </li>
                        </ul>
                        </div>
                    </div>
                    </nav>
                    <!-- Header -->
                    <div class="header backgound_login py-7 py-lg-8" >
                    <div class="container">
                        <div class="header-body text-center mb-7">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Bienvenido!</h1>
                            
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="separator separator-bottom separator-skew zindex-100">
                        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                        </svg>
                    </div>
                    </div>
                    <!-- Page content -->
                    <div class="container mt--8 pb-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-7">
                        <div class="card bg-secondary shadow border-0">
                            <div class="card-header bg-transparent pb-5">
                                
                                <div class="text-center text-muted mb-4">
                                    <small>Sign in</small>
                                </div>
                                <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/LOGIN_Controller.php?action=LOGIN">
                                    <div class="form-group mb-3">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Login" name="login" type="text" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" placeholder="Password" name="password" type="password" required>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        <?php if($_SESSION['ErrorPass'] == TRUE) { ?>
                                            <span class="text-muted">Login o Contraseña incorrectos</span>
                                        <?php } ?>
                                    </div>
                                    <div class="text-center">
                                        <button class="btn btn-primary my-4" name="action" type="submit">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                            <a href="../Controllers/REGISTRO_Controller.php" class="text-light"><small>Crea una cuenta</small></a>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <footer class="py-5">
                    <div class="container">
                        <div class="row align-items-center justify-content-xl-between">
                        <div class="col-xl-12">
                            <div class="copyright text-center text-xl-left text-muted">
                            © 2019 
                            </div>
                        </div>
                        
                        </div>
                    </div>
                    </footer>
                </div>
                <!--   Core   -->
                <script src="../Views/js/plugins/jquery/dist/jquery.min.js"></script>
                <script src="../Views/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
                <!--   Optional JS   -->
                <noscript>
                    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=111649226022273&ev=PageView&noscript=1" />
                </noscript>
                <!--   Argon JS   -->
                <script src="../Views/js/argon-dashboard.min.js?v=1.1.0"></script>
                <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
                <script>
                    window.TrackJS &&
                    TrackJS.install({
                        token: "ee6fab19c5a04ac1a32a645abde4613a",
                        application: "argon-dashboard-free"
                    });
                </script>
                

                </body>

                <!-- Footer -->
                <?php new Footer($this->msg); ?>
            </html>

        <?php
        }
    }
?>