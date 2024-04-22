<?php
ob_start();
?>
<?php
include_once '../control/configBd.php';
include_once '../control/ControlEntidad.php';
include_once '../control/ControlConexionPdo.php';
include_once '../modelo/Entidad.php';
session_start();
if($_SESSION['email']==null)header('Location: index.php');
$permisoParaEntrar=false;
$listaRolesDelUsuario=$_SESSION['listaRolesDelUsuario'];
for($i=0;$i<count($listaRolesDelUsuario);$i++){
    if($listaRolesDelUsuario[$i]->__get('nombre')=="Admin")$permisoParaEntrar=true;
}
if(!$permisoParaEntrar)header('Location: index.php');

$objControlSubSeccion = new ControlEntidad('subseccion');
$arregloSubSecciones = $objControlSubSeccion->listar();
?>
<?php include 'header.html'; ?>
<?php include 'body.php'; ?>
<?php include 'modalLogin.php'; ?>

<section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <div class="container-xl">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-5">
                                <h2><b>Administrar</b> SubSecciones</h2>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Id</th>
                                <th>Nombre</th>	
                                <th></th>					
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Paginación
                            $registros_por_pagina = 5;
                            $total_registros = count($arregloSubSecciones);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            //cargar tabla
                            for($i = $inicio; $i < $fin && $i < $total_registros; $i++){
                                $num_registro = $i + 1;
                                $getid = $arregloSubSecciones[$i]->__get('id');
                                $getnombre = $arregloSubSecciones[$i]->__get('nombre');
                            ?>

                            <tr>
                                <td><?= $num_registro ?></td>
                                <td><?= $getid ?></td>
                                <td><?= $getnombre ?></td>
                                <td></td>                      
                            </tr>
                            <?php
                            }
                            $registros_mostrados = min($registros_por_pagina, $total_registros - $inicio);
                            ?>
                        </tbody>
                    </table>
                    <!-- Mostrar enlaces de paginación -->
                    <div class="clearfix">
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de <b><?= $total_registros ?></b> subsecciones</div>
                        <ul class="pagination">
                            <?php 
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaSubSeccion.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i=1; $i <= $total_paginas; $i++) { 
                                if($pagina_actual == $i){
                                    echo "<li class='page-item active'><a href='vistaSubSeccion.php?pagina=$i' class='page-link'>$i</a></li>";
                                }else{
                                    echo "<li class='page-item'><a href='vistaSubSeccion.php?pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='VistaSeccion.php?pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>       
    </div>
</section><!-- End Hero -->

<main id="main">
     
</main><!-- End #main -->

<?php include 'footer.html'; ?>
<?php
  ob_end_flush();
?>