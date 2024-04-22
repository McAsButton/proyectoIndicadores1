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
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo '<li class="dropdown"><a href="#"><span>Vistas</span> <i class="bi bi-chevron-down"></i></a>';
                        echo '<ul>';
                        echo '<li><a href="vistaFuente.php">Vista Fuente</a></li>';
                        echo '<li><a href="vistaRepresenVisual.php">Vista Represen Visual</a></li>';
                        echo '<li><a href="vistaRol.php">Vista Rol</a></li>';
                        echo '<li><a href="vistaSeccion.php">Vista Sección</a></li>';
                        echo '<li><a href="vistaSentido.php">Vista Sentido</a></li>';
                        echo '<li><a href="vistaSubSeccion.php">Vista Sub Sección</a></li>';
                        echo '<li><a href="vistaTipoActor.php">Vista Tipo Actor</a></li>';
                        echo '<li><a href="vistaTipoIndicador.php">Vista Tipo Indicador</a></li>';
                        echo '<li><a href="vistaUnidadMedicion.php">Vista Unidad Medición</a></li>';
                        echo '<li><a href="vistaUsuario.php">Vista Usuario</a></li>';
                        echo '</ul>';
                        echo '</li>';
                    }
                    ?>
                    <li>
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo '<a class="nav-link scrollto" href="cerrarSesion.php">Cerrar Sesión</a>';
                    }
                    else
                    {
                        echo '<a class="nav-link scrollto" data-bs-toggle="modal" data-bs-target="#ModalLogin" role="button">Login</a>';
                    }
                    ?> 
                    </li>  
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->