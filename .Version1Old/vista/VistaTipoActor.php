<?php 
include '../control/ControlTipoActor.php';
include '../modelo/TipoActor.php';

$ControlTipoActor = new ControlTipoActor(null); // 
$comandoSql = $ControlTipoActor->listar(); // 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $id = $_POST["id"]; 
    $nombre = $_POST["nombre"]; 
    $action = $_POST["action"]; 

    if (!empty($id)) { 
        $TipoActor = new TipoActor($id, $nombre); 
        $ControlTipoActor = new ControlTipoActor($TipoActor); 
        if($action == 'modificar'){ // Si la acción es modificar
            $ControlTipoActor->modificar();
            header("Location: VistaTipoActor.php");
            exit();
        }elseif($action == 'guardar'){
            $ControlTipoActor->agregar();
            header("Location: VistaTipoActor.php");
            exit();
        } elseif ($action == 'delete') {
            $ControlTipoActor->eliminar($id);
            header("Location: VistaTipoActor.php");
            exit();
        }
    }
}
include 'header.php'; ?>

<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <div class="container-xl">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-sm-5">
                                <h2><b>Administrar</b> Tipo Actor</h2>
                            </div>
                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTipoActor"><i class="bi bi-person-plus"></i><span>Nuevo Tipo Actor</span></button>
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
                            // Obtener todos los registros
                            $registros_completos = $comandoSql->fetchAll(PDO::FETCH_ASSOC); // Obtiene todos los registros de la consulta

                            // Configuración de la paginación
                            $registros_por_pagina = 5; // Cambiar según la cantidad deseada por página
                            $total_registros = count($registros_completos); // Cantidad total de registros
                            $total_paginas = ceil($total_registros / $registros_por_pagina); // Cantidad total de páginas a mostrar
                            $pagina_actual = isset($_GET['nume']) ? $_GET['nume'] : 1; // Página actual por GET
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina; // Registro de inicio de la página actual
                            $registros_pagina = array_slice($registros_completos, $inicio, $registros_por_pagina); // Registros a mostrar en la página actual

                            foreach ($registros_pagina as $indice => $dato) {
                                $num_registro = $inicio + $indice + 1;
                            ?>
                            <tr>
                                <td><?= $num_registro ?></td>
                                <td><?= $dato['id'] ?></td>
                                <td><?= $dato['nombre'] ?></td>
                                <td></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="post" action="VistaTipoActor.php" enctype="multipart/form-data">
                                            <button type="button" class="btn btn-warning btn-sm" name="modificar" data-bs-toggle="modal" data-bs-target="#editTipoActor" data-bs-whatever="<?= $dato['id'] ?>"><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button>
                                        </form>
                                        <form method="post" action="VistaTipoActor.php" enctype="multipart/form-data">
                                            <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteTipoActor" data-bs-id="<?= $dato['id'] ?>"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
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
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?> de <b><?= $total_registros ?></b> usuarios</div>
                        <ul class="pagination">
                            <?php 
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='VistaTipoActor.php?nume=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i=1; $i <= $total_paginas; $i++) { 
                                if($pagina_actual == $i){
                                    echo "<li class='page-item active'><a href='VistaTipoActor.php?nume=$i' class='page-link'>$i</a></li>";
                                }else{
                                    echo "<li class='page-item'><a href='VistaTipoActor.php?nume=$i' class='page-link'>$i</a></li>";
                                }
                            }
                        
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='VistaTipoActor.php?nume=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
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
    <div class="modal fade" id="addTipoActor" tabindex="-1" aria-labelledby="addTipoActor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="VistaTipoActor.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Tipo Actor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='id' value="" class="form-control" placeholder="Id" aria-label="Id" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='nombre' class="form-control" placeholder="Nombre" aria-label="nombre" aria-describedby="basic-addon1">
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="guardar">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" formmethod="post" name="guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- Edit Modal HTML -->
    <div class="modal fade" id="editTipoActor" tabindex="-1" aria-labelledby="editTipoActor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="VistaTipoActor.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Tipo Actor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='id' value="" class="form-control" placeholder="Id" aria-label="Id" aria-describedby="basic-addon1" id="id" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='nombre' class="form-control" placeholder="Nombre" aria-label="nombre" aria-describedby="basic-addon1">
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="modificar">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning" formmethod="post" name="modificar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- Delete Modal HTML -->
    <div class="modal fade" id="deleteTipoActor" tabindex="-1" aria-labelledby="editTipoActor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="post" action="VistaTipoActor.php" enctype="multipart/form-data">
                <div class="modal-header">						
                    <h4 class="modal-title">Borrar Tipo Actor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">					
                    <p>Esta seguro que desea eliminar este Tipo Actor?</p>
                    <p class="text-warning"><small>Esta accion no se puede deshacer.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="id" value="<?= $dato['id'] ?>" id="id">
                    <input type="hidden" name="nombre" value="<?= $dato['nombre'] ?>" id="nombre">
                    <input type="hidden" name="action" value="delete">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning" formmethod="post" name="delete" id="confirmDelete">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
    </div>     
</main><!-- End #main -->

<script>
const editTipoActor = document.getElementById('editTipoActor')
if (editTipoActor) {
    editTipoActor.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const TipoActor = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const modalTitle = editTipoActor.querySelector('.modal-title')
        const idInput = editTipoActor.querySelector('#id')
        
        modalTitle.textContent = `Modificar Tipo Actor ${TipoActor}`
        idInput.value = TipoActor
    })
}

const deleteTipoActor = document.getElementById('deleteTipoActor')
if (deleteTipoActor) {
    deleteTipoActor.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id')
        const nombre = button.getAttribute('data-bs-nombre')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const modalTitle = deleteTipoActor.querySelector('.modal-title')
        const idInput = deleteTipoActor.querySelector('#id')
        
        modalTitle.textContent = `Eliminar Tipo Actor ${id}`
        idInput.value = id
    })
}
</script>

<?php include 'footer.php'; ?>