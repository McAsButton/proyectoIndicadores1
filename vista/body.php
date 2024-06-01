<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center justify-content-between">
            <h1 class="logo"><a href="index.php">devCrypt</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="index.php#about">Acerca de</a></li><!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <li><a class="nav-link scrollto" href="index.php#services">Servicios</a></li><!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <li><a class="nav-link scrollto " href="index.php#portfolio">Portafolio</a></li><!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <li><a class="nav-link scrollto" href="index.php#team">Equipo</a></li><!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <li><a class="nav-link scrollto" href="index.php#contact">Contacto</a></li><!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <?php
                    if (isset($_SESSION['email'])) {
                        $listaRolesDelUsuario = $_SESSION['listaRolesDelUsuario'];
                        // Verificar si el usuario es Admin
                        for ($i = 0; $i < count($listaRolesDelUsuario); $i++) {
                            if ($listaRolesDelUsuario[$i]->__get('nombre') == "Admin") {
                                $_SESSION['admin'] = true;
                            }
                            if ($listaRolesDelUsuario[$i]->__get('nombre') == "Verificador") {
                                $_SESSION['verificador'] = true;
                            }
                            if ($listaRolesDelUsuario[$i]->__get('nombre') == "Validador") {
                                $_SESSION['validador'] = true;
                            }
                            if ($listaRolesDelUsuario[$i]->__get('nombre') == "Administrativo") {
                                $_SESSION['administrativo'] = true;
                            }
                            if ($listaRolesDelUsuario[$i]->__get('nombre') == "Invitado") {
                                $_SESSION['invitado'] = true;
                            }
                        }
                        // Mostrar menú de usuario
                        if (isset($_SESSION['admin'])) {
                            echo '<li class="dropdown"><a href="#"><span>Usuario</span> <i class="bi bi-chevron-down"></i></a>';
                            echo '<ul>';
                            echo '<li><a href="vistaRol.php">Rol</a></li>';
                            echo '<li><a href="vistaUsuario.php">Usuario</a></li>';
                            echo '</ul>';
                            echo '</li>';
                        }
                        // Mostrar menú de indicadores
                        if (isset($_SESSION['admin']) || isset($_SESSION['verificador']) || isset($_SESSION['validador']) || isset($_SESSION['administrativo'])) {
                            echo '<li class="dropdown"><a href="#"><span>Indicadores</span> <i class="bi bi-chevron-down"></i></a>';
                            echo '<ul>';
                            echo '<li><a href="vistaActor.php">Actor</a></li>';
                            echo '<li><a href="vistaConsultas.php">Consultas</a></li>';
                            echo '<li><a href="vistaFrecuencia.php">Frecuencia</a></li>';
                            echo '<li><a href="vistaFuente.php">Fuente</a></li>';
                            echo '<li><a href="vistaIndicador.php">Indicador</a></li>';
                            echo '<li><a href="vistaRepresenVisual.php">Represen Visual</a></li>';
                            echo '<li><a href="vistaResultadoIndicador.php">Resultado Indicador</a></li>';
                            echo '<li><a href="vistaSentido.php">Sentido</a></li>';
                            echo '<li><a href="vistaTipoActor.php">Tipo Actor</a></li>';
                            echo '<li><a href="vistaTipoIndicador.php">Tipo Indicador</a></li>';
                            echo '<li><a href="vistaUnidadMedicion.php">Unidad Medición</a></li>'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
                            echo '<li><a href="vistaVariable.php">Variable</a></li>';
                            echo '</ul>';
                            echo '</li>';
                        }
                    }
                    ?>
                    <li>
                        <?php
                        if (isset($_SESSION['email'])) {
                            echo '<p id="parrafoUsuario">' . $_SESSION['email'] . '<br> Rol: ';
                            $roles = ['admin' => 'Admin <i class="bi bi-person-gear"></i>', 'verificador' => 'Verificador <i class="bi bi-person-exclamation"></i>', 'validador' => 'Validador <i class="bi bi-person-check"></i>', 'administrativo' => 'Administrativo <i class="bi bi-person-add"></i>', 'invitado' => 'Invitado <i class="bi bi-person-lock"></i>'];
                            foreach ($roles as $key => $value) {
                                if (isset($_SESSION[$key])) {
                                    echo $value . ' ';
                                }
                            }
                            echo '</p>';
                            echo '<a class="nav-link scrollto" href="cerrarSesion.php">Cerrar Sesión</a>'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
                        } else {
                            echo '<a class="nav-link scrollto" data-bs-toggle="modal" data-bs-target="#ModalLogin" role="button">Login</a>'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
                        }
                        ?>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header>
    <script>
        window.addEventListener("DOMContentLoaded", () => {
            const parrafo = document.querySelector("#parrafoUsuario");

            function actualizarClase() {
                if (window.innerWidth < 992) {
                    parrafo.classList.remove("text-light");
                    parrafo.classList.add("text-black");
                } else {
                    parrafo.classList.remove("text-black");
                    parrafo.classList.add("text-light");
                }
            }

            actualizarClase(); // Actualizar clase al cargar la página

            window.addEventListener("resize", actualizarClase); // Actualizar clase al cambiar el tamaño de la ventana
        });
    </script><!-- End Header -->