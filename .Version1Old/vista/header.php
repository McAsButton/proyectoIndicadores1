<!DOCTYPE html>
<html lang="en">
    <head>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>devCrypt</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!-- Vendor CSS Files -->
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
        <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
        <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/miStyle.css">

        <!-- =======================================================
        * Template Name: Dewi
        * Template URL: https://bootstrapmade.com/dewi-free-multi-purpose-html-template/
        * Updated: Mar 17 2024 with Bootstrap v5.3.3
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
        <!-- <style>
            #ModalLogin .modal-content, #ModalLogin input{
            background-color: #f0f4f8;
            }
        </style> -->
    </head>
<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="index.php">devCrypt</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            <nav id="navbar" class="navbar">
                <ul>
                <li><a class="nav-link scrollto" href="index.php#about">Acerca de</a></li> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <li><a class="nav-link scrollto" href="index.php#services">Servicios</a></li> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <li><a class="nav-link scrollto " href="index.php#portfolio">Portafolio</a></li> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <li><a class="nav-link scrollto" href="index.php#team">Equipo</a></li> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <li><a class="nav-link scrollto" href="index.php#contact">Contacto</a></li> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                <li class="dropdown"><a href="#"><span>Vistas</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                    <li><a href="VistaFuente.php">Vista Fuente</a></li>
                    <li><a href="VistaRepresenVisual.php">Vista Represen Visual</a></li>
                    <li><a href="VistaRol.php">Vista Rol</a></li>
                    <li><a href="VistaSeccion.php">Vista Sección</a></li><!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <li><a href="VistaSentido.php">Vista Sentido</a></li>
                    <li><a href="VistaSubSeccion.php">Vista Sub Sección</a></li><!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <li><a href="VistaTipoActor.php">Vista Tipo Actor</a></li>
                    <li><a href="VistaTipoIndicador.php">Vista Tipo Indicador</a></li>
                    <li><a href="VistaUnidadMedicion.php">Vista Unidad Medición</a></li><!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <li><a href="VistaUsuario.php">Vista Usuario</a></li>
                    </ul>
                </li>
                <li><a class="nav-link scrollto" data-bs-toggle="modal" data-bs-target="#ModalLogin" role="button">Login</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->
    <!-- Modal Login -->
    <!-- Modal Form -->
    <div class="modal fade" id="ModalLogin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Login Form -->
            <form action="">
                <div class="modal-header">
                <h5 class="modal-title">Iniciar sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label for="Username">Usuario<span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" id="Username" placeholder="Ingrese Usuario">
                </div>

                <div class="mb-3">
                    <label for="Password">Contraseña<span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" id="Password" placeholder="Ingrese Contraseña">
                </div>
                <div class="mb-3">
                    <input class="form-check-input" type="checkbox" value="" id="remember" required>
                    <label class="form-check-label" for="remember">Recordarme</label>
                    <a href="#" class="float-end">Olvide mi contraseña</a>
                </div>
                </div>
                <div class="modal-footer pt-4">                  
                <button type="button" class="btn btn-success mx-auto w-100">Iniciar Sesión</button>
                </div>
                <p class="text-center">No tienea una cuenta, <a href="#">Regístrate</a></p> 
            </form>
        </div>
        </div>
    </div>
    <!-- Modal Login-->