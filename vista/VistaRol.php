<?php
include '../control/ControlRol.php';
include '../modelo/Rol.php';

$controlRol = new ControlRol(null);
$comandoSql = $controlRol->listar(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $id = $_POST["id"]; 
    $nombre = $_POST["nombre"]; 
    $action = $_POST["action"]; 

    if (!empty($id)) { 
        $objRol = new Rol($id, $nombre); 
        $controlRol = new ControlRol($objRol); 
        if($action == 'modificar'){ 
            $controlRol->modificar();
            header("Location: VistaRol.php");
            exit();
        }elseif($action == 'guardar'){
            $controlRol->agregar();
            header("Location: VistaRol.php");
            exit();
        } elseif ($action == 'delete') {
            $controlRol->eliminar($id);
            header("Location: VistaRol.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Administración de Rol</title>
<!-- Favicons -->
<link href="assets/img/favicon.png" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="assets/css/miStyle.css">
</head>
<body>
<div class="container-xl">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-5">
                        <h2><b>Administrar</b> Rol</h2>
                    </div>
                    <div class="col-sm-7">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRol"><i class="bi bi-person-plus"></i><span>Nuevo Rol</span></button>
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
                    $num = 0;
                    foreach ($comandoSql as $dato) {
                        $num++;
                    ?>
                    <tr>
                        <td><?= $num ?></td>
                        <td><?= $dato['id'] ?></td>
                        <td><?= $dato['nombre'] ?></td>
                        <td>
                            <div class="btn-group" role="group">
                                <form method="post" action="VistaRol.php" enctype="multipart/form-data">
                                    <button type="button" class="btn btn-warning btn-sm" name="modificar" data-bs-toggle="modal" data-bs-target="#editRol" data-bs-whatever="<?= $dato['id'] ?>"><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button>
                                </form>
                                <form method="post" action="VistaRol.php" enctype="multipart/form-data">
                                    <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteRol" data-bs-id="<?= $dato['id'] ?>"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
                                </form>
                            </div>
                        </td>                        
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Add Modal HTML -->
<div class="modal fade" id="addRol" tabindex="-1" aria-labelledby="addRol" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="post" action="VistaRol.php" enctype="multipart/form-data">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Rol</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">A</span>
                        <input type="text" name='id' value="" class="form-control" placeholder="Id" aria-label="id" aria-describedby="basic-addon1">
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
<div class="modal fade" id="editRol" tabindex="-1" aria-labelledby="editRol" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="post" action="VistaRol.php" enctype="multipart/form-data">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Rol</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">A</span>
                        <input type="text" name='id' value="" class="form-control" placeholder="Id" aria-label="id" aria-describedby="basic-addon1" id="id" readonly>
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
<div class="modal fade" id="deleteRol" tabindex="-1" aria-labelledby="editRol" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="deleteForm" method="post" action="VistaRol.php" enctype="multipart/form-data">
            <div class="modal-header">						
                <h4 class="modal-title">Borrar Rol</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">					
                <p>Esta seguro que desea eliminar esta Rol?</p>
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
</body>
<script>
const editRol = document.getElementById('editRol')
if (editRol) {
    editRol.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const Rol = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const modalTitle = editRol.querySelector('.modal-title')
        const idInput = editRol.querySelector('#id')
        
        modalTitle.textContent = `Modificar Rol ${Rol}`
        idInput.value = Rol
    })
}

const deleteRol = document.getElementById('deleteRol')
if (deleteRol) {
    deleteRol.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id')
        const nombre = button.getAttribute('data-bs-nombre')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const modalTitle = deleteRol.querySelector('.modal-title')
        const idInput = deleteRol.querySelector('#id')
        
        modalTitle.textContent = `Eliminar Rol ${id}`
        idInput.value = id
    })
}
</script>
</html>