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

$objControlTipoActor = new ControlEntidad('tipoactor');
$arregloTipoActor = $objControlTipoActor->listar();

$boton = $_POST['bt'] ?? ''; // Captura el valor del botón
$id = $_POST['txtId'] ?? ''; // Captura el valor del id
$nombre = $_POST['txtNombre'] ?? ''; // Captura el valor del nombre

switch($boton){
    case 'Guardar':
        $datosTipoActor = ['id' => $id, 'nombre' => $nombre];
        $objTipoActor = new Entidad($datosTipoActor);
        $objControlTipoActor = new ControlEntidad('tipoactor');
        $objControlTipoActor->guardar($objTipoActor);
        header('Location: vistaTipoActor.php');
        break;
    case 'Modificar':
      $datosTipoActor = ['id' => $id, 'nombre' => $nombre];
      $objTipoActor = new Entidad($datosTipoActor);
      $objControlTipoActor = new ControlEntidad('tipoactor');
      $objControlTipoActor->modificar('id', $id, $objTipoActor);
      header('Location: vistaTipoActor.php');
      break;
    case 'Eliminar':
      $objControlTipoActor = new ControlEntidad('tipoactor');
      $objControlTipoActor->borrar('id', $id);
      header('Location: vistaTipoActor.php');
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
                            $registros_por_pagina = 5;
                            $total_registros = count($arregloTipoActor);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for($i = $inicio; $i < $fin && $i < $total_registros; $i++){
                              $num_registro = $i + 1;
                              $getid = $arregloTipoActor[$i]->__get('id');
                              $getnombre = $arregloTipoActor[$i]->__get('nombre');
                            ?>
                            <tr>
                                <td><?= $num_registro ?></td>
                                <td><?= $getid ?></td>
                                <td><?= $getnombre ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="post" action="VistaTipoActor.php" enctype="multipart/form-data">
                                            <button type="button" class="btn btn-warning btn-sm" name="modificar" data-bs-toggle="modal" data-bs-target="#editTipoActor" data-bs-whatever="<?= $getid ?>"data-bs-name="<?= $getnombre ?>"><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button>
                                        </form>
                                        <form method="post" action="VistaTipoActor.php" enctype="multipart/form-data">
                                            <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteTipoActor" data-bs-id="<?= $getid ?>"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
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
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de <b><?= $total_registros ?></b> tipos de actores</div>
                        <ul class="pagination">
                            <?php 
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaTipoActor.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i=1; $i <= $total_paginas; $i++) { 
                                if($pagina_actual == $i){
                                    echo "<li class='page-item active'><a href='vistaTipoActor.php?pagina=$i' class='page-link'>$i</a></li>";
                                }else{
                                    echo "<li class='page-item'><a href='vistaTipoActor.php?pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaTipoActor.php?pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Tipo de Actor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id" aria-label="id" aria-describedby="basic-addon1">
                        </div>
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
    <div class="modal fade" id="editTipoActor" tabindex="-1" aria-labelledby="editTipoActor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="vistaTipoActor.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Tipo de Actor</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id" aria-label="id" aria-describedby="basic-addon1" id="id" readonly>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" name='txtNombre' id="txtNombre" class="form-control" placeholder="Nombre" aria-label="nombre" aria-describedby="basic-addon1">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning" formmethod="post" name="bt" Value="Modificar">Guardar</button>
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
                    <h4 class="modal-title">Borrar Tipo de Actor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">					
                    <p>Esta seguro que desea eliminar este Tipo de Actor?</p>
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
const editTipoActor = document.getElementById('editTipoActor')
if (editTipoActor) {
    editTipoActor.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const TipoActor = button.getAttribute('data-bs-whatever')
        const Nombre = button.getAttribute('data-bs-name')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.
        console.log(TipoActor)
        console.log(Nombre)

        // Update the modal's content.
        const modalTitle = editTipoActor.querySelector('.modal-title')
        const idInput = editTipoActor.querySelector('#txtId')
        const nombreInput = editTipoActor.querySelector('#txtNombre')
        
        modalTitle.textContent = `Modificar TipoActor ${TipoActor}`
        idInput.value = TipoActor
        nombreInput.value = Nombre
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
        const idInput = deleteTipoActor.querySelector('#txtId')
        
        modalTitle.textContent = `Eliminar TipoActor ${id}`
        idInput.value = id
    })
}
</script>

<?php include 'footer.html'; ?>
<?php
  ob_end_flush();
?>