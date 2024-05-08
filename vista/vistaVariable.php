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
if($_SESSION['email']==null)header('Location: index.php');
$permisoParaEntrar=false;
$listaRolesDelUsuario=$_SESSION['listaRolesDelUsuario'];
for($i=0;$i<count($listaRolesDelUsuario);$i++){
    if($listaRolesDelUsuario[$i]->__get('nombre')=="Admin")$permisoParaEntrar=true;
}
if(!$permisoParaEntrar)header('Location: index.php');

$objControlActor = new ControlEntidad('variable');
$arregloActor = $objControlActor->listar();

$boton = $_POST['bt'] ?? ''; // Captura el valor del botón
$id = $_POST['txtId'] ?? ''; // Captura el valor del id
$nombre = $_POST['txtNombre'] ?? ''; // Captura el valor del nombre
$fechacreacion = $_POST['txtFechaCreacion'] ?? '';
$fkemailusuario = $_POST['txtFkEmailUsuario'] ?? '';

switch($boton){
    case 'Guardar':
        $datosActor = ['id' => $id, 'nombre' => $nombre, 'fechacreacion' => $fechacreacion, 'fkemailusuario' => $fkemailusuario];
        $objActor = new Entidad($datosActor);
        $objControlActor = new ControlEntidad('variable');
        $objControlActor->guardar($objActor);
        header('Location: vistaActor.php');
        break;
    case 'Modificar':
      $datosActor = ['id' => $id, 'nombre' => $nombre, 'fechacreacion' => $fechacreacion, 'fkemailusuario' => $fkemailusuario];
      $objActor = new Entidad($datosActor);
      $objControlActor = new ControlEntidad('variable');
      $objControlActor->modificar('id', $id,  $objActor);
      header('Location: vistaActor.php');
      break;
    case 'Eliminar':
        try{            
            // Intentar eliminar el registro
            $objControlActor = new ControlEntidad('variable');
            $objControlActor->borrar('id', $id, 'nombre', $nombre, 'fechacreacion', $fechacreacion, 'fkemailusuario', $fkemailusuario);
            header('Location: vistaActor.php?spawnNote=1');
        }catch(PDOException $e){
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
                            <div class="col-sm-5">
                                <h2><b>Administrar</b> Variable </h2>
                            </div>
                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addActor"><i class="bi bi-person-plus"></i><span>Nueva Variable</span></button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Fecha Crecion</th>
                                <th>FkEmailUsuario</th>						
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
                                $getfechacreacion = $arregloActor[$i]->__get('fechacreacion');
                                $getfkemailusuario = $arregloActor[$i]->__get('fkemailusuario');
                            
                                // Aquí se busca el nombre de la variable correspondiente al fkemailusuario
                                $nombre = ''; // Variable para almacenar el nombre de la variable
                                foreach ($arregloActor as $actor) {
                                    if ($actor->__get('id') == $getfkemailusuario) {
                                        $nombre = $actor->__get('nombre');
                                        break; // Salir del bucle una vez encontrado la variable
                                    }
                                }
                            ?>
                            <tr>
                                <td><?= $num_registro ?></td>
                                <td><?= $getid ?></td>
                                <td><?= $getnombre ?></td>
                                <td><?= $getfechacreacion ?></td>
                                <td><?= $getfkemailusuario ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="post" action="VistaActor.php" enctype="multipart/form-data">
                                            <button type="button" class="btn btn-warning btn-sm" name="modificar" data-bs-toggle="modal" data-bs-target="#editActor" data-bs-whatever="<?= $getid ?>"data-bs-nombre="<?= $getnombre ?>"data-bs-fechacreacion="<?= $getfechacreacion ?>"data-bs-fkemailusuario="<?= $getfkemailusuario ?>"><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button>
                                        </form>
                                        <form method="post" action="VistaActor.php" enctype="multipart/form-data">
                                            <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteActor" data-bs-id="<?= $getid ?>"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
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
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de <b><?= $total_registros ?></b>Actores</div>
                        <ul class="pagination">
                            <?php 
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaActor.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i=1; $i <= $total_paginas; $i++) { 
                                if($pagina_actual == $i){
                                    echo "<li class='page-item active'><a href='vistaActor.php?pagina=$i' class='page-link'>$i</a></li>";
                                }else{
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Variable</h1>
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
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtFechaCreacion' id="txtFechaCreacion" class="form-control" placeholder="FechaCreacion" aria-label="fechacreacion" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtFkEmailUsuario' id="txtFkEmailUsuario" class="form-control" placeholder="FkEmailUsuario" aria-label="fkemailusuario" aria-describedby="basic-addon1">
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
    <div class="modal fade" id="editActor" tabindex="-1" aria-labelledby="editActor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="VistaActor.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Variable</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="input-group mb-3" hidden>
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtId' id="txtId" value="" class="form-control" placeholder="Id" aria-label="id" aria-describedby="basic-addon1" id="id" readonly>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtNombre' id="txtNombre" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtFechaCreacion' id="txtFechaCreacion" class="form-control" placeholder="Fecha Creacion" aria-label="fechacreacion" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">A</span>
                    <input type="text" name='txtFkEmailUsuario' id="txtFkEmailUsuario" class="form-control" placeholder="FkEmailUsuario" aria-label="fkemailusuario" aria-describedby="basic-addon1">
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
    <div class="modal fade" id="deleteActor" tabindex="-1" aria-labelledby="deleteActor" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="post" action="VistaActor.php" enctype="multipart/form-data">
                <div class="modal-header">						
                    <h4 class="modal-title">Borrar Variable</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">					
                    <p>Esta seguro que desea eliminar este Variable?</p>
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
    window.addEventListener("DOMContentLoaded",() => {
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

    const editActor = document.getElementById('editActor')
    if (editActor) {
        editActor.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-whatever')
            const Nombre = button.getAttribute('data-bs-nombre')
            const FechaCreacion = button.getAttribute('data-bs-fechacreacion')
            const FkEmailUsuario = button.getAttribute('data-bs-fkemailusuario')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.
           

            // Update the modal's content.
            const modalTitle = editActor.querySelector('.modal-title')
            const nombreInput = editActor.querySelector('#txtNombre')
            const fechacreacionInput = editActor.querySelector('#txtFechaCreacion')
            const fkemailusuarioInput = editActor.querySelector('#txtFkEmailUsuario')
            
            modalTitle.textContent = `Modificar Variable ${id}`
           
            nombreInput.value = Nombre
            fechacreacionInput.value = FechaCreacion
            fkemailusuarioInput.value = FkEmailUsuario
        })
    }

    const deleteActor = document.getElementById('deleteActor')
    if (deleteActor) {
        deleteActor.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id')
            const nombre = button.getAttribute('data-bs-nombre')
            const fechacreacion = button.getAttribute('data-bs-fechacreacion')
            const fkemailusuario = button.getAttribute('data-bs-fkemailusuario')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = deleteActor.querySelector('.modal-title')
            const idInput = deleteActor.querySelector('#txtId')
            
            modalTitle.textContent = `Eliminar Variable ${id}`
            idInput.value = id
        })
    }
</script>

<?php include 'footer.html'; ?>
<?php
  ob_end_flush();
?>