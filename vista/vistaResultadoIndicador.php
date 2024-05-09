<?php
ob_start();
?>
<?php
include_once '../control/configBd.php';
include_once '../control/ControlEntidad.php';
include_once '../control/ControlConexionPdo.php';
include_once '../modelo/Entidad.php';
include_once 'notificacion.html';

session_start();
if ($_SESSION['email'] == null)
    header('Location: index.php');
$permisoParaEntrar = false;
$listaRolesDelUsuario = $_SESSION['listaRolesDelUsuario'];
for ($i = 0; $i < count($listaRolesDelUsuario); $i++) {
    if ($listaRolesDelUsuario[$i]->__get('nombre') == "Admin")
        $permisoParaEntrar = true;
}
if (!$permisoParaEntrar)
    header('Location: index.php');

// Establecer la zona horaria a la local del servidor
date_default_timezone_set('America/Bogota');

$objControlResultadoIndicador = new ControlEntidad('resultadoindicador');
$arregloResultadoIndicador = $objControlResultadoIndicador->listar();

$boton = $_POST['bt'] ?? ''; // Captura el valor del botón
$id = $_POST['txtId'] ?? ''; // Captura el valor del id
$resultado = $_POST['txtResultado'] ?? ''; // Captura el valor del resultado
$fechaCalculo = $_POST['txtFechaCalculo'] ?? '';
$fkidIndicador = $_POST['txtFkidIndicador'] ?? '';
$fecha_y_hora = date("Y-m-d H:i:s");

switch ($boton) {
    case 'Guardar':
        $datosResultadoIndicador = ['id' => $id, 'resultado' => $resultado, 'fechacalculo' => $fechaCalculo, 'fkidindicador' => $fkidIndicador];
        $objResultadoIndicador = new Entidad($datosResultadoIndicador);
        $objControlResultadoIndicador = new ControlEntidad('resultadoindicador');
        $objControlResultadoIndicador->guardar($objResultadoIndicador);
        header('Location: vistaResultadoIndicador.php');
        break;
    case 'Modificar':
        $datosResultadoIndicador = ['id' => $id, 'resultado' => $resultado, 'fechacalculo' => $fechacalculo, 'fkidindicador' => $fkidindicador];
        $objResultadoIndicador = new Entidad($datosResultadoIndicador);
        $objControlResultadoIndicador = new ControlEntidad('resultadoindicador');
        $objControlResultadoIndicador->modificar('id', $id, $objResultadoIndicador);
        header('Location: vistaResultadoIndicador.php');
        break;
    case 'Eliminar':
        try {
            // Intentar eliminar el registro
            $objControlResultadoIndicador = new ControlEntidad('resultadoindicador');
            $objControlResultadoIndicador->borrar('id', $id);
            header('Location: vistaResultadoIndicador.php?spawnNote=1');
        } catch (PDOException $e) {
            header('Location: vistaResultadoIndicador.php?spawnNote=0');
        }
        break;
}
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
                                <h2><b>Administrar</b> Resultado Indicador</h2>
                            </div>
                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addResultadoIndicador"><i class="bi bi-person-plus"></i><span>Nuevo
                                        Resultado Indicador</span></button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Id</th>
                                <th>Resultado</th>
                                <th>Fecha Calculo</th>
                                <th>Indicador</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Paginación
                            $registros_por_pagina = 5;
                            $total_registros = count($arregloResultadoIndicador);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $num_registro = $i + 1;
                                $getid = $arregloResultadoIndicador[$i]->__get('id');
                                $getresultado = $arregloResultadoIndicador[$i]->__get('resultado');
                                $getfechacalculo = $arregloResultadoIndicador[$i]->__get('fechacalculo');
                                $getfkidindicador = $arregloResultadoIndicador[$i]->__get('fkidindicador');

                                $indicador = $arregloResultadoIndicador[$i]->__get('fkidindicador');
                                $objControlIndicador = new ControlEntidad('indicador');
                                $sql = "SELECT nombre FROM indicador WHERE id = ?";
                                $parametros = [$indicador];
                                $arregloResultadoIndicador = $objControlIndicador->consultar($sql, $parametros);
                                $getfkidindicador = $arregloResultadoIndicador[0]->__get('nombre');
                                ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $getid ?></td>
                                    <td><?= $getresultado ?></td>
                                    <td><?= $getfechacalculo ?></td>
                                    <td><?= $getfkidindicador ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form method="post" action="VistaResultadoIndicador.php"
                                                enctype="multipart/form-data">
                                                <button type="button" class="btn btn-warning btn-sm" name="modificar"
                                                    data-bs-toggle="modal" data-bs-target="#editResultadoIndicador"
                                                    data-bs-whatever="<?= $getid ?>"
                                                    data-bs-resultado="<?= $getresultado ?>"
                                                    data-bs-fechacalculo="<?= $getfechacalculo ?>"
                                                    data-bs-fkidindicador="<?= $getfkidindicador ?>"><i
                                                        class="bi bi-pencil-square"
                                                        style="font-size: 0.75rem;"></i></button>
                                            </form>
                                            <form method="post" action="VistaResultadoIndicador.php"
                                                enctype="multipart/form-data">
                                                <button type="button" class="btn btn-danger btn-sm" name="delete"
                                                    data-bs-toggle="modal" data-bs-target="#deleteResultadoIndicador"
                                                    data-bs-id="<?= $getid ?>"><i class="bi bi-trash-fill"
                                                        style="font-size: 0.75rem;"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            $registros_mostrados = min($registros_por_pagina, $total_registros - $inicio);
                            ?>
                        </tbody>
                    </table>
                    <!-- Mostrar enlaces de paginación -->
                    <div class="clearfix">
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de
                            <b><?= $total_registros ?></b> tipos de indicadores</div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaResultadoIndicador.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaResultadoIndicador.php?pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaResultadoIndicador.php?pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaResultadoIndicador.php?pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Hero -->

<main id="main">
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addResultadoIndicador" tabindex="-1" aria-labelledby="addResultadoIndicador"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaResultadoIndicador.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Resultado Indicador</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id" aria-label="id" aria-describedby="basic-addon1">
                </div> -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtResultado' id="txtResultado" class="form-control"
                                placeholder="Resultado" aria-label="resultado" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtFechaCalculo' id="txtFechaCalculo" class="form-control"
                                placeholder="FechaCalculo" aria-label="fechacalculo" aria-describedby="basic-addon1"
                                value="<?= $fecha_y_hora ?>">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtFkidIndicador' id="txtFkidIndicador" class="form-control"
                                placeholder="FkidIndicador" aria-label="fkidindicador" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" formmethod="post" name="bt"
                            value="Guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div class="modal fade" id="editResultadoIndicador" tabindex="-1" aria-labelledby="editResultadoIndicador"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaResultadoIndicador.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Resultado Indicador</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3" hidden>
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id"
                                aria-label="id" aria-describedby="basic-addon1" id="id" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtResultado' id="txtResultado" class="form-control"
                                placeholder="Resultado" aria-label="Resultado" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtFechaCalculo' id="txtFechaCalculo" class="form-control"
                                placeholder="Fecha Calculo" aria-label="fechacalculo" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtFkidIndicador' id="txtFkidIndicador" class="form-control"
                                placeholder="FkidIndicador" aria-label="fkidindicador" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt"
                            Value="Modificar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div class="modal fade" id="deleteResultadoIndicador" tabindex="-1" aria-labelledby="deleteResultadoIndicador"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="VistaResultadoIndicador.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Borrar Resultado Indicador</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Esta seguro que desea eliminar este Resultado Indicador?</p>
                        <p class="text-warning"><small>Esta accion no se puede deshacer.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="txtId" value="" id="txtId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt" value="Eliminar"
                            id="confirmDelete">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<script>
    window.addEventListener("DOMContentLoaded", () => {
        const nc = new NotificationCenter();

        // Crear un objeto URLSearchParams con la parte de búsqueda de la URL
        const params = new URLSearchParams(window.location.search);

        // Verificar si el parámetro spawnNote está en la URL
        if (params.has('spawnNote')) {
            // Obtener el valor del parámetro spawnNote
            const spawnNoteValue = parseInt(params.get('spawnNote'));

            // Llamar al método spawnNote con el valor obtenido
            nc.spawnNote(spawnNoteValue);
        }
    });

    const editResultadoIndicador = document.getElementById('editResultadoIndicador')
    if (editResultadoIndicador) {
        editResultadoIndicador.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-whatever')
            const Resultado = button.getAttribute('data-bs-resultado')
            const FechaCalculo = button.getAttribute('data-bs-fechacalculo')
            const FkidIndicador = button.getAttribute('data-bs-fkidindicador')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.


            // Update the modal's content.
            const modalTitle = editResultadoIndicador.querySelector('.modal-title')
            const resultadoInput = editResultadoIndicador.querySelector('#txtResultado')
            const fechacalculoInput = editResultadoIndicador.querySelector('#txtFechaCalculo')
            const fkidindicadorInput = editResultadoIndicador.querySelector('#txtFkidIndicador')

            modalTitle.textContent = `Modificar Resultado Indicador ${id}`

            resultadoInput.value = Resultado
            fechacalculoInput.value = FechaCalculo
            fkidindicadorInput.value = FkidIndicador
        })
    }

    const deleteResultadoIndicador = document.getElementById('deleteResultadoIndicador')
    if (deleteResultadoIndicador) {
        deleteResultadoIndicador.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id')
            const resultado = button.getAttribute('data-bs-resultado')
            const fechacalculo = button.getAttribute('data-bs-fechacalculo')
            const fkidindicador = button.getAttribute('data-bs-fkidindicador')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = deleteResultadoIndicador.querySelector('.modal-title')
            const idInput = deleteResultadoIndicador.querySelector('#txtId')

            modalTitle.textContent = `Eliminar Resultado Indicador ${id}`
            idInput.value = id
        })
    }
</script>

<?php include 'footer.html'; ?>
<?php
ob_end_flush();
?>