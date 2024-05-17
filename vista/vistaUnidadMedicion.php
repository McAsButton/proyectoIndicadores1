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

$objControlUnidadMedicion = new ControlEntidad('unidadmedicion');
$arregloUnidadesMedicion = $objControlUnidadMedicion->listar();

$boton = $_POST['bt'] ?? '';
$id = $_POST['txtId'] ?? '';
$descripcion = $_POST['txtDescripcion'] ?? '';
$consultarId = $_POST['txtConsultarId'] ?? ''; // Captura el valor del id a consultar

switch ($boton) {
    case 'Guardar':
        try {
            $datosUnidadMedicion = ['id' => $id, 'descripcion' => $descripcion];
            $objUnidadMedicion = new Entidad($datosUnidadMedicion);
            $objControlUnidadMedicion = new ControlEntidad('unidadmedicion');
            $objControlUnidadMedicion->guardar($objUnidadMedicion);
            header('Location: vistaUnidadMedicion.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaUnidadMedicion.php?spawnNote=0');
        }
        break;
    case 'Consultar':
        try {
            $datosUnidadMedicion = ['id' => $consultarId];
            $objUnidadMedicion = new Entidad($datosUnidadMedicion);
            $objControlUnidadMedicion = new ControlEntidad('unidadmedicion');
            $objUnidadMedicion = $objControlUnidadMedicion->buscarPorId('id', $consultarId);
            if ($objUnidadMedicion !== null) {
                $descripcion = $objUnidadMedicion->__get('descripcion');
                header('Location: vistaUnidadMedicion.php?id=' . $consultarId . '&descripcion=' . $descripcion);
            } else {
                header('Location: vistaUnidadMedicion.php?spawnNote=0');
                break;
            }
        } catch (Exception $e) {
            header('Location: vistaUnidadMedicion.php?spawnNote=0');
        }
        break;
    case 'Modificar':
        try {
            $datosUnidadMedicion = ['id' => $id, 'descripcion' => $descripcion];
            $objUnidadMedicion = new Entidad($datosUnidadMedicion);
            $objControlUnidadMedicion = new ControlEntidad('unidadmedicion');
            $objControlUnidadMedicion->modificar('id', $id, $objUnidadMedicion);
            header('Location: vistaUnidadMedicion.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaUnidadMedicion.php?spawnNote=0');
        }
        break;
    case 'Eliminar':
        try {
            $objControlUnidadMedicion = new ControlEntidad('unidadmedicion');
            $objControlUnidadMedicion->borrar('id', $id);
            header('Location: vistaUnidadMedicion.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaUnidadMedicion.php?spawnNote=0');
        }
        break;
}

?>

<?php include 'header.html'; ?>
<?php include 'body.php'; ?>
<?php include 'modalLogin.php'; ?>


<section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
            <div class="container-xl">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm">
                                    <h2><b>Administrar</b> Unidades de Medición</h2>
                                </div>
                                <div class="col-sm">
                                    <form class="d-flex" method="post" action="vistaUnidadMedicion.php">
                                        <input class="form-control mr-2 mb-1" type="search" placeholder="Buscar id" aria-label="Search" id="txtConsultarId" name="txtConsultarId">
                                        <button class="btn btn-outline-success" type="submit" formmethod="post" name="bt" value="Consultar"><i class="bi bi-search"></i></button>
                                    </form>
                                </div>
                                <div class="col-sm">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUnidadMedicion"><i class="bi bi-person-plus"></i><span>Nueva
                                            Unidad de Medición</span></button>
                                    <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                                </div>
                            </div>
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id</th>
                                    <th>Descripcion</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                // Paginación
                                $registros_por_pagina = 5;
                                $total_registros = count($arregloUnidadesMedicion);
                                $total_paginas = ceil($total_registros / $registros_por_pagina);
                                $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                                $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                                $fin = $inicio + $registros_por_pagina;


                                for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                    $num_registro = $i + 1;
                                    $getid = $arregloUnidadesMedicion[$i]->__get('id');
                                    $getdescricipcion = $arregloUnidadesMedicion[$i]->__get('descripcion');
                                ?>
                                    <tr>
                                        <td><?= $num_registro ?></td>
                                        <td><?= $getid ?></td>
                                        <td><?= $getdescricipcion ?></td>
                                        <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                                        <td>
                                            <div class="btn-group" role="group">
                                                <form method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data">
                                                    <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                                                    <button type="button" class="btn btn-warning btn-sm botonModificar" name="modificar" data-bs-toggle="modal" data-bs-target="#editUnidadMedicion" data-bs-whatever="<?= $getid ?>" data-bs-descripcion="<?= $getdescricipcion ?>"><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button>
                                                    <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                                                </form>
                                                <form method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data">
                                                    <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                                                    <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteUnidadMedicion" data-bs-id="<?= $getid ?>"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
                                                    <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
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
                                <b><?= $total_registros ?></b> unidades de medicion
                            </div>
                            <ul class="pagination">
                                <?php
                                // Botón "Anterior"
                                echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaUnidadMedicion.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                                // Números de página
                                for ($i = 1; $i <= $total_paginas; $i++) {
                                    if ($pagina_actual == $i) {
                                        echo "<li class='page-item active'><a href='vistaUnidadMedicion.php?pagina=$i' class='page-link'>$i</a></li>";
                                    } else {
                                        echo "<li class='page-item'><a href='vistaUnidadMedicion.php?pagina=$i' class='page-link'>$i</a></li>";
                                    }
                                }
                                // Botón "Siguiente"
                                echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaUnidadMedicion.php?pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<main id="main">
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addUnidadMedicion" tabindex="-1" aria-labelledby="addUnidadMedicion" aria-hidden="true">
        <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data">
                    <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Unidad de Medición</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtId' id="txtID" value="" class="form-control" placeholder="Id" aria-label="Id" aria-describedby="basic-addon1">
                </div> -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtDescripcion' id="txtDescripcion" class="form-control" placeholder="descripción" aria-label="descripcion" aria-describedby="basic-addon1">
                            <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" formmethod="post" name="bt" value="Guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div class="modal fade" id="editUnidadMedicion" tabindex="-1" aria-labelledby="editUnidadMedicion" aria-hidden="true"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data">
                    <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Unidad de Medición</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3" hidden>
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id" aria-label="Id" aria-describedby="basic-addon1" id="id" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtDescripcion' id="txtDescripcion" class="form-control" placeholder="Descripción" aria-label="descripcion" aria-describedby="basic-addon1">
                            <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="Cancelar2">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt" value="Modificar">Guardar</button>
                        <button type="submit" class="btn btn-danger" formmethod="post" name="bt" value="Eliminar" id="confirmDelete" hidden>Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div class="modal fade" id="deleteUnidadMedicion" tabindex="-1" aria-labelledby="deleteUnidadMedicion" aria-hidden="true"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data">
                    <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                    <div class="modal-header">
                        <h4 class="modal-title">Borrar Unidad de Medición</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Esta seguro que desea eliminar esta Unidad de Medición?</p>
                        <p class="text-warning"><small>Esta accion no se puede deshacer.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="txtId" value="" id="txtId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt" value="Eliminar" id="confirmDelete">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main><!-- End #main -->
<script>
    window.addEventListener("DOMContentLoaded", event => {
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
        if (params.has('id') && params.has('descripcion')) {
            const id = params.get('id');
            const descripcion = params.get('descripcion');

            // Abrir el modal
            const editUnidadMedicionModal = new bootstrap.Modal(document.getElementById('editUnidadMedicion'));
            // Hacer visible el botón confirmDelete
            document.getElementById('confirmDelete').removeAttribute('hidden');
            editUnidadMedicionModal.show();

            // Cargar los datos en el modal
            cargarDatos(id, descripcion);
        }
    });

    const openEditModalButton = document.getElementsByClassName('botonModificar');

    for (let i = 0; i < openEditModalButton.length; i++) {
        openEditModalButton[i].addEventListener('click', function() {
            const id = this.getAttribute('data-bs-whatever');
            const descripcion = this.getAttribute('data-bs-descripcion');
            const editUnidadMedicionModal = new bootstrap.Modal(document.getElementById('editUnidadMedicion'));
            // Hacer invisible el botón confirmDelete
            document.getElementById('confirmDelete').setAttribute('hidden', 'true');
            editUnidadMedicionModal.show();

            // Cargar los datos en el modal
            cargarDatos(id, descripcion);
        });
    }

    const CancelarEditButton = document.getElementById('Cancelar2');

    if (CancelarEditButton) {
        CancelarEditButton.addEventListener('click', () => {
            const editUnidadMedicionModal = new bootstrap.Modal(document.getElementById('editUnidadMedicion'));
            editUnidadMedicionModal.hide();

            //Eliminar la clase .modal-backdrop
            const mocalBackdrop = document.querySelector('.modal-backdrop');
            if (mocalBackdrop) {
                mocalBackdrop.remove();
            }
        });
    }

    function cargarDatos(id, descripcion) {
        const modalTitle = editUnidadMedicion.querySelector('.modal-title');
        const idInput = editUnidadMedicion.querySelector('#txtId');
        const descripcionInput = editUnidadMedicion.querySelector('#txtDescripcion');

        modalTitle.textContent = `Modificar Unidad de Medicion ${id}`;
        idInput.value = id;
        descripcionInput.value = descripcion;
    }

    const deleteUnidadMedicion = document.getElementById('deleteUnidadMedicion') // cspell:disable-line <- desabilita el corrector ortografico para esta linea
    if (deleteUnidadMedicion) {
        deleteUnidadMedicion.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = deleteUnidadMedicion.querySelector('.modal-title')
            const idInput = deleteUnidadMedicion.querySelector('#txtId')

            modalTitle.textContent = `Eliminar Unidad de Medición ${id}`
            idInput.value = id
        })
    }
</script>

<?php include 'footer.html'; ?>
<?php
ob_end_flush();
?>