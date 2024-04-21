<?php
ob_start();
?>
<?php
include_once '../control/configBd.php';
include_once '../control/ControlEntidad.php';
include_once '../control/ControlConexionPdo.php';
include_once '../modelo/Entidad.php';

$arregloRolesConsulta=[];

$objControlUsuario = new ControlEntidad('usuario');
$arregloUsuarios = $objControlUsuario->listar();
$objControlRol = new ControlEntidad('rol');
$arregloRoles = $objControlRol->listar();
?>
<?php include 'header.html'; ?>
<?php include 'body.html'; ?>
<?php include 'modalLogin.php'; ?>

<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <div class="container-xl separador">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row d-flex align-items-center">
                            <div class="col-sm-5">
                                <h2><b>Administrar</b> Usuarios</h2>
                            </div>
                            <div class="col-sm-7">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser"><i class="bi bi-person-plus"></i><span>Nuevo Usuario</span></button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Email</th>
                                <th>Contraseña</th>						
                                <th>Rol</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        for($i = 0; $i < count($arregloUsuarios); $i++){
                            $num_registro = $i + 1;
                        ?>
                            <tr>
                                <td><?= $num_registro ?></td>
                                <td><?php echo $arregloUsuarios[$i]->__get('email');?></td>
                                <td><?php echo $arregloUsuarios[$i]->__get('contrasena');?></td>
                                <td></td>
                                <td>
                                    <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                    <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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
    </div>
</section><!-- End Hero -->
<main id="main">
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaUsuario.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">@</span>
                            <input type="email" name='email' value="" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">**</span>
                            <input type="password" name='contrasena' class="form-control" placeholder="Contraseña" aria-label="Contrasena" aria-describedby="basic-addon1" required>
                        </div>
                        <h5>Selecciona el rol:</h5>
                        <div class="container mt-3">
                            <?php for($i = 0; $i < count($arregloRoles); $i++){ 
                                $id = $arregloUsuarios[$i]->__get('id');?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles_modal[<?= $id ?>]" value="<?= $id ?>" id="opcion<?= $id ?>_modal1">
                                    <label class="form-check-label" for="opcion<?= $id ?>_modal1">
                                        <?= $opcion['nombre'] ?>
                                    </label>
                                </div>
                            <?php }?>
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
    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaUsuario.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">@</span>
                                <input type="email" name='email' value="" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" id="email" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">**</span>
                                <input type="password" name='contrasena' class="form-control" placeholder="Contraseña" aria-label="Contrasena" aria-describedby="basic-addon1" id="contrasena">
                            </div>
                            <h5>Selecciona el rol:</h5>
                            <div class="container mt-3" id="checkboxes-container">
                            <?php 
                            foreach ($roles_nombres2 as $opcion): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles_modal[<?= $id ?>]" value="<?= $id ?>" id="opcion<?= $id ?>_modal2">
                                    <label class="form-check-label" for="opcion<?= $id ?>_modal2">
                                        <?= $opcion['nombre'] ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>                        
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
    <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="editUser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="VistaUsuario.php" enctype="multipart/form-data">
                    <div class="modal-header">						
                        <h4 class="modal-title">Borrar Usuario</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">					
                        <p>Esta seguro que desea eliminar este usuario?</p>
                        <p class="text-warning"><small>Esta accion no se puede deshacer.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="email" value="<?= $dato['email'] ?>" id="emaildel">
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
    const editUser = document.getElementById('editUser')
    if (editUser) {
        editUser.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget
            const user = button.getAttribute('data-bs-email')
            const pass = button.getAttribute('data-bs-pass')
            const rolesJSONString = button.getAttribute('data-bs-roles');
            
            function decodeEntities(encodedString) {
                var textArea = document.createElement('textarea');
                textArea.innerHTML = encodedString;
                return textArea.value;
            }

            const rolesJSON = decodeEntities(rolesJSONString);
            const roles = JSON.parse(rolesJSON);

            const modalTitle = editUser.querySelector('.modal-title')
            const emailInput = editUser.querySelector('#email')
            const passInput = editUser.querySelector('#contrasena')
            const checkboxesContainer = editUser.querySelector('#checkboxes-container')
            
            modalTitle.textContent = `Modificar usuario ${user}`
            emailInput.value = user
            passInput.value = pass;

            // Resetear todos los checkboxes a falso
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Activar checks en base a fkidrol
            roles.forEach(rol => {
                const checkbox = checkboxesContainer.querySelector(`#opcion${rol.fkidrol}_modal2`)
                if (checkbox) {
                    checkbox.checked = true
                }
            })



            // Validar checkboxes para el modal de editar usuario
            const checkboxesEdit = document.querySelectorAll('#editUser .form-check-input');
            const modifyButtonEdit = document.querySelector('#editUser [name="modificar"]');

            function validarCheckboxesEdit() {
                let alMenosUnoSeleccionado = false;
                checkboxesEdit.forEach(checkbox => {
                    if (checkbox.checked) {
                        alMenosUnoSeleccionado = true;
                    }
                });

                if (alMenosUnoSeleccionado) {
                    modifyButtonEdit.disabled = false;
                } else {
                    modifyButtonEdit.disabled = true;
                }
            }

            checkboxesEdit.forEach(checkbox => {
                checkbox.addEventListener('click', validarCheckboxesEdit);
            });

            validarCheckboxesEdit(); // Para validar en el inicio, cuando el modal se abre por primera vez
        
        })
    }

    const deleteUser = document.getElementById('deleteUser')
    if (deleteUser) {
        deleteUser.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const email = button.getAttribute('data-bs-email')
            const contrasena = button.getAttribute('data-bs-contrasena')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = deleteUser.querySelector('.modal-title')
            const emailInput = deleteUser.querySelector('#emaildel')
            
            modalTitle.textContent = `Eliminar usuario ${email}`
            emailInput.value = email
        })
    }

    // Validar checkboxes para el modal de agregar usuario
    const checkboxesAdd = document.querySelectorAll('#addUser .form-check-input');
    const saveButtonAdd = document.querySelector('#addUser [name="guardar"]');

    function validarCheckboxesAdd() {
        let alMenosUnoSeleccionado = false;
        checkboxesAdd.forEach(checkbox => {
            if (checkbox.checked) {
                alMenosUnoSeleccionado = true;
            }
        });

        if (alMenosUnoSeleccionado) {
            saveButtonAdd.disabled = false;
        } else {
            saveButtonAdd.disabled = true;
        }
    }

    checkboxesAdd.forEach(checkbox => {
        checkbox.addEventListener('click', validarCheckboxesAdd);
    });

    validarCheckboxesAdd(); // Para validar en el inicio, cuando el modal se abre por primera vez
</script>

<?php include 'footer.html'; ?>
<?php
  ob_end_flush();
?>