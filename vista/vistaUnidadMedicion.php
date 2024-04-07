<?php
include '../control/ControlUnidadMedicion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea
include '../modelo/UnidadMedicion.php'; // cspell:disable-line <- desabilita el corrector ortografico para esta linea

$ControlUnidadMedicion = new ControlUnidadMedicion(null); // 
$comandoSql = $ControlUnidadMedicion->listar(); // 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $id = $_POST["id"]; 
    $descripcion = $_POST["descripcion"]; // cspell:disable-line <- desabilita el corrector ortografico para esta linea 
    $action = $_POST["action"]; 

    if (!empty($id)) { 
        $UnidadMedicion = new UnidadMedicion($id, $descripcion); 
        $ControlUnidadMedicion = new ControlUnidadMedicion($UnidadMedicion); 
        if($action == 'modificar'){ // Si la acción es modificar
            $ControlUnidadMedicion->modificar();
            header("Location: VistaUnidadMedicion.php"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
            exit();
        }elseif($action == 'guardar'){
            $ControlUnidadMedicion->agregar();
            header("Location: VistaUnidadMedicion.php"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
            exit();
        } elseif ($action == 'delete') {
            $ControlUnidadMedicion->eliminar($id);
            header("Location: VistaUnidadMedicion.php"); // cspell:disable-line <- desabilita el corrector ortografico para esta linea
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
<title>Administración de Unidad de Medicion</title>
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
                        <h2><b>Administrar</b> Unidad de medición</h2>
                    </div>
                    <div class="col-sm-7">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUnidadMedicion"><i class="bi bi-person-plus"></i><span>Nuevo Unidad de Medición</span></button> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
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
                    $num = 0;
                    foreach ($comandoSql as $dato) {
                        $num++;
                    ?>
                    <tr>
                        <td><?= $num ?></td>
                        <td><?= $dato['id'] ?></td>
                        <td><?= $dato['descripcion'] ?></td> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                        <td></td>
                        <td>
                            <div class="btn-group" role="group">
                                <form method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                                    <button type="button" class="btn btn-warning btn-sm" name="modificar" data-bs-toggle="modal" data-bs-target="#editUnidadMedicion" data-bs-whatever="<?= $dato['id'] ?>"><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                                </form>
                                <form method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
                                    <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteUnidadMedicion" data-bs-id="<?= $dato['id'] ?>"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
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
<div class="modal fade" id="addUnidadMedicion" tabindex="-1" aria-labelledby="addUnidadMedicion" aria-hidden="true"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Unidad de Medición</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Id</span>
                        <input type="text" name='id' value="" class="form-control" placeholder="Id" aria-label="Id" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Descripción</span>
                        <input type="text" name='descripcion' class="form-control" placeholder="descripción" aria-label="descripcion" aria-describedby="basic-addon1"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
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
<div class="modal fade" id="editUnidadMedicion" tabindex="-1" aria-labelledby="editUnidadMedicion" aria-hidden="true"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Unidad de Medición</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Id</span>
                        <input type="text" name='id' value="" class="form-control" placeholder="Id" aria-label="Id" aria-describedby="basic-addon1" id="id" readonly>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Descripción</span>
                        <input type="text" name='descripcion' class="form-control" placeholder="Descripción" aria-label="descripcion" aria-describedby="basic-addon1"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
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
<div class="modal fade" id="deleteUnidadMedicion" tabindex="-1" aria-labelledby="editUnidadMedicion" aria-hidden="true"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="deleteForm" method="post" action="VistaUnidadMedicion.php" enctype="multipart/form-data"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
            <div class="modal-header">						
                <h4 class="modal-title">Borrar Unidad de Medición</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">					
                <p>Esta seguro que desea eliminar esta Unidad de Medición?</p>
                <p class="text-warning"><small>Esta accion no se puede deshacer.</small></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" value="<?= $dato['id'] ?>" id="id">
                <input type="hidden" name="descripcion" value="<?= $dato['descripcion'] ?>" id="descripcion"> <!-- cspell:disable-line <- desabilita el corrector ortografico para esta linea -->
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
const editUnidadMedicion = document.getElementById('editUnidadMedicion') // cspell:disable-line <- desabilita el corrector ortografico para esta linea
if (editUnidadMedicion) {
    editUnidadMedicion.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const UnidadMedicion = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const modalTitle = editUnidadMedicion.querySelector('.modal-title')
        const idInput = editUnidadMedicion.querySelector('#id')
        
        modalTitle.textContent = `Modificar Unidad de Medición ${UnidadMedicion}`
        idInput.value = UnidadMedicion
    })
}

const deleteUnidadMedicion = document.getElementById('deleteUnidadMedicion') // cspell:disable-line <- desabilita el corrector ortografico para esta linea
if (deleteUnidadMedicion) {
    deleteUnidadMedicion.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const id = button.getAttribute('data-bs-id')
        const descripcion = button.getAttribute('data-bs-descripcion') // cspell:disable-line <- desabilita el corrector ortografico para esta linea
        // If necessary, you could initiate an Ajax request here
        // and then do the updating in a callback.

        // Update the modal's content.
        const modalTitle = deleteUnidadMedicion.querySelector('.modal-title')
        const idInput = deleteUnidadMedicion.querySelector('#id')
        
        modalTitle.textContent = `Eliminar Unidad de Medición ${id}`
        idInput.value = id
    })
}
</script>
</html>