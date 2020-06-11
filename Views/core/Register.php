<?php

    class Register {

        function __construct(){
            $this->pinta();
        }

    function pinta(){        

        ?>

            <html lang="en"><head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>
                Club Padel
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
                                <a class="nav-link nav-link-icon" href="../Controllers/LOGIN_Controller.php">
                                    <i class="ni ni-single-02"></i>
                                    <span class="nav-link-inner--text">Login</span>
                                </a>
                            </li>
                            <!--li class="nav-item">
                                <a class="nav-link nav-link-icon" href="../Controller/Register_Controller.php">
                                    <i class="ni ni-circle-08"></i>
                                    <span class="nav-link-inner--text">Register</span>
                                </a>
                            </li-->
                        </ul>
                        </div>
                    </div>
                    </nav>
                    <!-- Header -->
                    <div class="header backgound_login py-7 py-lg-8">
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
                                        <small>Registrarse</small>
                                    </div>
                                    <form role="form" enctype="multipart/form-data" method="post" action="../Controllers/REGISTRO_Controller.php">
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                            </div>
                                            <input class="form-control" name="login" placeholder="Login" type="text">
                                        </div>
                                    </div>    
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                            </div>
                                            <input class="form-control" name="password" placeholder="Password" type="password">
                                        </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                            </div>
                                            <input class="form-control" name="nombre" placeholder="Nombre" type="text">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                            </div>
                                            <input class="form-control" name="apellidos" placeholder="Apellidos" type="text">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                    <i class="fa fa-venus-mars"></i> <label class="form-control-label" for="input-genero">Genero</label>
                                        <select class="browser-default custom-select" name="genero" id="input-genero">
                                            <option value='Masculino'>Masculino</option>
                                            <option value='Femenino'>Femenino</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group input-group-alternative mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                            </div>
                                            <input class="form-control" name="email" placeholder="Email" type="text">
                                        </div>
                                    </div>
                                   
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary mt-4">Crear cuenta</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    <footer class="py-5">
                    <div class="container">
                        <div class="row align-items-center justify-content-xl-between">
                        <div class="col-xl-6">
                            <div class="copyright text-center text-xl-left text-muted">
                            © 2019 
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
                            </li>
                            </ul>
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
                  
            </html>

        <?php
        }
    }
?>