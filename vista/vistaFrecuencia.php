<?php
ob_start();
?>
<?php
include_once '../control/configBd.php';
include_once '../control/ControlEntidad.php';
include_once '../control/ControlConexionPdo.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include_once '../modelo/Entidad.php';
include_once 'notificacion.html'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
session_start();
if ($_SESSION['email'] == null)
    header('Location: index.php');
$permisoParaEntrar = false;
if (isset($_SESSION['admin']) || isset($_SESSION['verificador']) || isset($_SESSION['validador']) || isset($_SESSION['administrativo']))
    $permisoParaEntrar = true;

if (!$permisoParaEntrar)
    header('Location: index.php');

$objControlFrecuencia = new ControlEntidad('frecuencia');
$arregloFrecuencia = $objControlFrecuencia->listar();

$boton = $_POST['bt'] ?? ''; // Captura el valor del botón
$id = $_POST['txtId'] ?? ''; // Captura el valor del id
$nombre = $_POST['txtNombre'] ?? ''; // Captura el valor del nombre
$consultarId = $_POST['txtConsultarId'] ?? ''; // Captura el valor del id a consultar

switch ($boton) {
    case 'Guardar':
        try {
            $datosFrecuencia = ['id' => $id, 'nombre' => $nombre];
            $objFrecuencia = new Entidad($datosFrecuencia);
            $objControlFrecuencia = new ControlEntidad('frecuencia');
            $objControlFrecuencia->guardar($objFrecuencia);
            header('Location: vistaFrecuencia.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaFrecuencia.php?spawnNote=0');
        }
        break;
    case 'Consultar':
        try {
            $datosFrecuencia = ['id' => $consultarId];
            $objFrecuencia = new Entidad($datosFrecuencia);
            $objControlFrecuencia = new ControlEntidad('frecuencia');
            $objFrecuencia = $objControlFrecuencia->buscarPorId('id', $consultarId);
            if ($objFrecuencia !== null) {
                $nombre = $objFrecuencia->__get('nombre');
                header('Location: vistaFrecuencia.php?id=' . $consultarId . '&nombre=' . $nombre);
            } else {
                header('Location: vistaFrecuencia.php?spawnNote=0');
                break;
            }
        } catch (Exception $e) {
            header('Location: vistaFrecuencia.php?spawnNote=0');
        }
        break;
    case 'Modificar':
        try {
            $datosFrecuencia = ['id' => $id, 'nombre' => $nombre];
            $objFrecuencia = new Entidad($datosFrecuencia);
            $objControlFrecuencia = new ControlEntidad('frecuencia');
            $objControlFrecuencia->modificar('id', $id, $objFrecuencia);
            header('Location: vistaFrecuencia.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaFrecuencia.php?spawnNote=0');
        }
        break;
    case 'Eliminar':
        try {
            $objControlFrecuencia = new ControlEntidad('frecuencia');
            $objControlFrecuencia->borrar('id', $id);
            header('Location: vistaFrecuencia.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaFrecuencia.php?spawnNote=0');
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
                            <div class="col-sm">
                                <h2><b>Administrar</b> Frecuencias</h2>
                            </div>
                            <div class="col-sm">
                                <form class="d-flex" method="post" action="vistaFrecuencia.php">
                                    <input class="form-control mr-2 mb-1" type="search" placeholder="Buscar id" aria-label="Search" id="txtConsultarId" name="txtConsultarId">
                                    <button class="btn btn-outline-success" type="submit" formmethod="post" name="bt" value="Consultar"><i class="bi bi-search"></i></button>
                                </form>
                            </div>
                            <div class="col-sm">
                                <?php
                                if (isset($_SESSION['admin']) || isset($_SESSION['administrativo'])) {
                                ?>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFrecuencia"><i class="bi bi-person-plus"></i><span>Nueva
                                            Frecuencia</span></button>
                                <?php
                                } else {
                                ?>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFrecuencia" disabled><i class="bi bi-person-plus"></i><span>Nueva
                                            Frecuencia</span></button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Paginación
                            $registros_por_pagina = 5;
                            $total_registros = count($arregloFrecuencia);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $num_registro = $i + 1;
                                $getid = $arregloFrecuencia[$i]->__get('id');
                                $getnombre = $arregloFrecuencia[$i]->__get('nombre');
                            ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $getid ?></td>
                                    <td><?= $getnombre ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <?php
                                            if (isset($_SESSION['admin']) || isset($_SESSION['administrativo']) || isset($_SESSION['validador'])) {
                                            ?>
                                                <form method="post" action="vistaFrecuencia.php" enctype="multipart/form-data">
                                                    <button type="button" class="btn btn-warning btn-sm botonModificar" name="modificar" data-bs-toggle="modal" data-bs-target="#editFrecuencia" data-bs-whatever="<?= $getid ?>" data-bs-name="<?= $getnombre ?>"><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button>
                                                </form>
                                                <form method="post" action="vistaFrecuencia.php" enctype="multipart/form-data">
                                                    <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteFrecuencia" data-bs-id="<?= $getid ?>"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
                                                </form>
                                            <?php
                                            } else {
                                            ?>
                                                <form method="post" action="vistaFrecuencia.php" enctype="multipart/form-data">
                                                    <button type="button" class="btn btn-warning btn-sm botonModificar" name="modificar" data-bs-toggle="modal" data-bs-target="#editFrecuencia" data-bs-whatever="<?= $getid ?>" data-bs-name="<?= $getnombre ?>" disabled><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button>
                                                </form>
                                                <form method="post" action="vistaFrecuencia.php" enctype="multipart/form-data">
                                                    <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteFrecuencia" data-bs-id="<?= $getid ?>" disabled><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
                                                </form>
                                            <?php
                                            }
                                            ?>
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
                            <b><?= $total_registros ?></b> frecuencias
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaFrecuencia.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaFrecuencia.php?pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaFrecuencia.php?pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaFrecuencia.php?pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
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
    <div class="modal fade" id="addFrecuencia" tabindex="-1" aria-labelledby="addFrecuencia" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="vistaFrecuencia.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Frecuencia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id" aria-label="id" aria-describedby="basic-addon1">
                </div> -->
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtNombre' id="txtNombre" class="form-control" placeholder="Nombre" aria-label="nombre" aria-describedby="basic-addon1">
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
    <div class="modal fade" id="editFrecuencia" tabindex="-1" aria-labelledby="editFrecuencia" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="vistaFrecuencia.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar frecuencia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3" hidden>
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id" aria-label="id" aria-describedby="basic-addon1" id="id" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtNombre' id="txtNombre" class="form-control" placeholder="Nombre" aria-label="nombre" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="Cancelar2">Cancelar</button>
                        <?php
                        if (isset($_SESSION['admin']) || isset($_SESSION['administrativo']) || isset($_SESSION['validador'])) {
                        ?>
                            <button type="submit" class="btn btn-warning" formmethod="post" name="bt" Value="Modificar">Guardar</button>
                            <button type="submit" class="btn btn-danger" formmethod="post" name="bt" value="Eliminar" id="confirmDelete" hidden>Eliminar</button>
                        <?php
                        } else {
                        ?>
                            <button type="submit" class="btn btn-warning" formmethod="post" name="bt" Value="Modificar" disabled>Guardar</button>
                            <button type="submit" class="btn btn-danger" formmethod="post" name="bt" value="Eliminar" id="confirmDelete" hidden disabled>Eliminar</button>
                        <?php
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div class="modal fade" id="deleteFrecuencia" tabindex="-1" aria-labelledby="deleteFrecuencia" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="vistaFrecuencia.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Borrar frecuencia</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Esta seguro que desea eliminar esta frecuencia?</p>
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
        if (params.has('id') && params.has('nombre')) {
            const id = params.get('id');
            const nombre = params.get('nombre');

            // Abrir el modal
            const editFrecuenciaModal = new bootstrap.Modal(document.getElementById('editFrecuencia'));
            // Hacer visible el botón confirmDelete
            document.getElementById('confirmDelete').removeAttribute('hidden');
            editFrecuenciaModal.show();

            // Cargar los datos en el modal
            cargarDatos(id, nombre);
        }
    });

    const openEditModalButton = document.getElementsByClassName('botonModificar');

    for (let i = 0; i < openEditModalButton.length; i++) {
        openEditModalButton[i].addEventListener('click', function() {
            const id = this.getAttribute('data-bs-whatever');
            const nombre = this.getAttribute('data-bs-name');
            const editFrecuenciaModal = new bootstrap.Modal(document.getElementById('editFrecuencia'));
            // Hacer invisible el botón confirmDelete
            document.getElementById('confirmDelete').setAttribute('hidden', 'true');
            editFrecuenciaModal.show();

            // Cargar los datos en el modal
            cargarDatos(id, nombre);
        });
    }

    const CancelarEditButton = document.getElementById('Cancelar2');

    if (CancelarEditButton) {
        CancelarEditButton.addEventListener('click', () => {
            const editFrecuenciaModal = new bootstrap.Modal(document.getElementById('editFrecuencia'));
            editFrecuenciaModal.hide();

            //Eliminar la clase .modal-backdrop
            const mocalBackdrop = document.querySelector('.modal-backdrop');
            if (mocalBackdrop) {
                mocalBackdrop.remove();
            }
        });
    }

    function cargarDatos(id, nombre) {
        const modalTitle = editFrecuencia.querySelector('.modal-title');
        const idInput = editFrecuencia.querySelector('#txtId');
        const nombreInput = editFrecuencia.querySelector('#txtNombre');

        modalTitle.textContent = `Modificar Frecuencia ${id}`;
        idInput.value = id;
        nombreInput.value = nombre;
    }

    const deleteFrecuencia = document.getElementById('deleteFrecuencia')
    if (deleteFrecuencia) {
        deleteFrecuencia.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id')
            const nombre = button.getAttribute('data-bs-nombre')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = deleteFrecuencia.querySelector('.modal-title')
            const idInput = deleteFrecuencia.querySelector('#txtId')

            modalTitle.textContent = `Eliminar Frecuencia ${id}`
            idInput.value = id
        })
    }
</script>

<?php include 'footer.html'; ?>
<?php
ob_end_flush();
?>