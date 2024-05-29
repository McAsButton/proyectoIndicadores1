<?php
ob_start();
?>
<?php
include_once '../control/configBd.php';
include_once '../control/ControlEntidad.php';
include_once '../control/ControlConexionPdo.php'; //cspell:disable-line
include_once '../modelo/Entidad.php';
include_once 'notificacion.html'; //cspell:disable-line

session_start();
if ($_SESSION['email'] == null)
    header('Location: index.php');
$permisoParaEntrar = false;
if (isset($_SESSION['admin']) || isset($_SESSION['verificador']) || isset($_SESSION['validador']) || isset($_SESSION['administrativo']))
    $permisoParaEntrar = true;
if (!$permisoParaEntrar)
    header('Location: index.php');

// Establecer la zona horaria a la local del servidor
date_default_timezone_set('America/Bogota');
?>
<?php include 'header.html'; ?>
<?php include 'body.php'; ?>
<?php include 'modalLogin.php'; ?>

<section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <div class="container-xl separador">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-sm">
                                <h2><b>Administrar</b> Consultas</h2>
                            </div>
                            <div class="col-sm">

                            </div>
                            <div class="col-sm">
                                <form class="d-flex" method="post" action="VistaConsultas.php">
                                    <!-- Listado con las consultas -->
                                    <button class="btn btn-outline-success" type="submit" formmethod="post" name="bt" value="Consultar"><i class="bi bi-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="main">

</main><!-- End #main -->
<script>

</script>

<?php include 'footer.html'; ?>
<?php
ob_end_flush();
?>