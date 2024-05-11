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

$objControlActor = new ControlEntidad('actor');
$arregloActor = $objControlActor->listar();

$boton = $_POST['bt'] ?? ''; // Captura el valor del botón
$id = $_POST['txtId'] ?? ''; // Captura el valor del id
$nombre = $_POST['txtNombre'] ?? ''; // Captura el valor del nombre
$fkidtipoactor = $_POST['txtFkidTipoActor'] ?? '';
$consultarId = $_POST['txtConsultarId'] ?? '';

switch ($boton) {
    case 'Guardar':
        try {
            $datosActor = ['id' => $id, 'nombre' => $nombre, 'fkidtipoactor' => $fkidtipoactor];
            $objActor = new Entidad($datosActor);
            $objControlActor = new ControlEntidad('actor');
            $objControlActor->guardar($objActor);
            header('Location: vistaActor.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaActor.php?spawnNote=0');
        }
        break;
    case 'Consultar':
        try {
            $datosActor = ['id' => $consultarId];
            $objActor = new Entidad($datosActor);
            $objControlActor = new ControlEntidad('actor');
            $objActor = $objControlActor->buscarPorId('id', $consultarId);

            if ($objActor !== null) {
                $nombre = $objActor->__get('nombre');
                $tipoactor = $objActor->__get('fkidtipoactor');
                header('Location: vistaActor.php?id=' . $consultarId . '&nombre=' . $nombre . '&fkidtipoactor=' . $tipoactor);
            } else {
                header('Location: vistaActor.php?spawnNote=0');
            }
        } catch (Exception $e) {
            header('Location: vistaActor.php?spawnNote=0');
        }
        break;
    case 'Modificar':
        try {
            $datosActor = ['id' => $id, 'nombre' => $nombre, 'fkidtipoactor' => $fkidtipoactor];
            $objActor = new Entidad($datosActor);
            $objControlActor = new ControlEntidad('actor');
            $objControlActor->modificar('id', $id, $objActor);
            header('Location: vistaActor.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaActor.php?spawnNote=0');
        }
        break;
    case 'Eliminar':
        try {
            // Intentar eliminar el registro
            $objControlActor = new ControlEntidad('actor');
            $objControlActor->borrar('id', $id);
            header('Location: vistaActor.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: vistaActor.php?spawnNote=0');
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
                                <h2><b>Administrar</b> Actor</h2>
                            </div>
                            <div class="col-sm">
                                <form class="d-flex" method="post" action="VistaActor.php">
                                    <input class="form-control mr-2 mb-1" type="search" placeholder="Buscar id"
                                        aria-label="Search" id="txtConsultarId" name="txtConsultarId">
                                    <button class="btn btn-outline-success" type="submit" formmethod="post" name="bt"
                                        value="Consultar"><i class="bi bi-search"></i></button>
                                </form>
                            </div>
                            <div class="col-sm">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addActor"><i class="bi bi-person-plus"></i><span>Nuevo
                                        Actor</span></button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Tipo de Actor</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            // Paginación
                            $registros_por_pagina = 5;
                            $total_registros = count($arregloActor);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $num_registro = $i + 1;
                                $getid = $arregloActor[$i]->__get('id');
                                $getnombre = $arregloActor[$i]->__get('nombre');

                                $tipoactor = $arregloActor[$i]->__get('fkidtipoactor');
                                $objControlTipoActor = new ControlEntidad('tipoactor');
                                $sql = "SELECT * FROM tipoactor WHERE id = ?";
                                $parametros = [$tipoactor];
                                $arreglotipoactor = $objControlTipoActor->consultar($sql, $parametros);
                                $getfkidtipoactor = $arreglotipoactor[0]->__get('nombre');
                                $getfkidtipoactorid = $arreglotipoactor[0]->__get('id');
                                ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $getid ?></td>
                                    <td><?= $getnombre ?></td>
                                    <td><?= $getfkidtipoactor ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form method="post" action="VistaActor.php" enctype="multipart/form-data">
                                                <button type="button" class="btn btn-warning btn-sm botonModificar"
                                                    name="modificar" data-bs-toggle="modal" data-bs-target="#editActor"
                                                    data-bs-whatever="<?= $getid ?>" data-bs-nombre="<?= $getnombre ?>"
                                                    data-bs-fkidtipoactor="<?= $getfkidtipoactorid ?>"><i
                                                        class="bi bi-pencil-square"
                                                        style="font-size: 0.75rem;"></i></button>
                                            </form>
                                            <form method="post" action="VistaActor.php" enctype="multipart/form-data">
                                                <button type="button" class="btn btn-danger btn-sm" name="delete"
                                                    data-bs-toggle="modal" data-bs-target="#deleteActor"
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
                            <b><?= $total_registros ?></b> Actores
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaActor.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaActor.php?pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaActor.php?pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaActor.php?pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
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
    <div class="modal fade" id="addActor" tabindex="-1" aria-labelledby="addActor" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaActor.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Actor</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id"
                                aria-label="id" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtNombre' id="txtNombre" class="form-control" placeholder="Nombre"
                                aria-label="Nombre" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtFkidTipoActor' id="txtFkidTipoActor" class="form-control"
                                placeholder="FkidActor" aria-label="fkidtipoactor" aria-describedby="basic-addon1">
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
    <div class="modal fade" id="editActor" tabindex="-1" aria-labelledby="editActor" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaActor.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Actor</h1>
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
                            <input type="text" name='txtNombre' id="txtNombre" class="form-control" placeholder="Nombre"
                                aria-label="nombre" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtFkidTipoActor' id="txtFkidTipoActor" class="form-control"
                                placeholder="Fkidactor" aria-label="fkidtipoactor" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="Cancelar2">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt"
                            Value="Modificar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div class="modal fade" id="deleteActor" tabindex="-1" aria-labelledby="deleteActor" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="VistaActor.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Borrar Actor</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Esta seguro que desea eliminar este Actor?</p>
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
        if (params.has('id') && params.has('nombre') && params.has('fkidtipoactor')) {
            const id = params.get('id');
            const nombre = params.get('nombre');
            const fkidtipoactor = params.get('fkidtipoactor');

            const editActorModal = new bootstrap.Modal(document.getElementById('editActor'));
            editActorModal.show();

            cargarDatos(id, nombre, fkidtipoactor);
        }
    });

    const openEditModalButton = document.getElementsByClassName('botonModificar');

    for (let i = 0; i < openEditModalButton.length; i++) {
        openEditModalButton[i].addEventListener('click', function () {
            const id = this.getAttribute('data-bs-whatever');
            const nombre = this.getAttribute('data-bs-nombre');
            const fkidtipoactor = this.getAttribute('data-bs-fkidtipoactor');

            const editActorModal = new bootstrap.Modal(document.getElementById('editActor'));
            editActorModal.show();

            cargarDatos(id, nombre, fkidtipoactor);
        });
    }

    const CancelarEditButton = document.getElementById('Cancelar2');

    if (CancelarEditButton) {
        CancelarEditButton.addEventListener('click', () => {
            const editRolModal = new bootstrap.Modal(document.getElementById('editActor'));
            editRolModal.hide();

            //Eliminar la clase .modal-backdrop
            const mocalBackdrop = document.querySelector('.modal-backdrop');
            if (mocalBackdrop) {
                mocalBackdrop.remove();
            }
        });
    }

    function cargarDatos(id, nombre, fkidtipoactor) {
        const modalTitle = editActor.querySelector('.modal-title');
        const idInput = editActor.querySelector('#txtId');
        const nombreInput = editActor.querySelector('#txtNombre');
        const fkidtipoactorInput = editActor.querySelector('#txtFkidTipoActor');

        modalTitle.textContent = `Modificar Actor ${id}`;
        idInput.value = id;
        nombreInput.value = nombre;
        fkidtipoactorInput.value = fkidtipoactor;
    }

    const deleteActor = document.getElementById('deleteActor')
    if (deleteActor) {
        deleteActor.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id')
            const nombre = button.getAttribute('data-bs-nombre')
            const fkidtipoactor = button.getAttribute('data-bs-fkidtipoactor')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = deleteActor.querySelector('.modal-title')
            const idInput = deleteActor.querySelector('#txtId')

            modalTitle.textContent = `Eliminar Actor ${id}`
            idInput.value = id
        })
    }
</script>

<?php include 'footer.html'; ?>
<?php
ob_end_flush();
?>