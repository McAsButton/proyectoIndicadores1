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

$arregloRolesConsulta=[];

$objControlUsuario = new ControlEntidad('usuario');
$arregloUsuarios = $objControlUsuario->listar();
$objControlRol = new ControlEntidad('rol');
$arregloRoles = $objControlRol->listar();


$boton = $_POST['bt'] ?? ''; // Captura el valor del botón
$email = $_POST['txtEmail'] ?? ''; // Captura el email del formulario
$contrasena = $_POST['txtContrasena'] ?? ''; // Captura la contraseña del formulario
$roles_modal = $_POST['roles_modal'] ?? []; // Captura los roles seleccionados del formulario
$roles = implode(", ", $roles_modal) ?? ''; // Convierte el array de roles en un string separado por comas

switch ($boton) {
    case 'Guardar':
         //1. modifica en tabla principal  
        $datosUsuario = ['email' => $email, 'contrasena' => $contrasena];
        $objUsuario = new Entidad($datosUsuario);
		$objControlUsuario = new ControlEntidad('usuario');
		$objControlUsuario->guardar($objUsuario);
        //2. tomar del arreglo de roles los id y guardar los datos en la tabla intermedia
        if (!empty($roles_modal)) {
			foreach ($roles_modal as $key => $id) {
                $datosRolUsuario = ['fkemail' => $email, 'fkidrol' => $id];
                $objRolUsuario = new Entidad($datosRolUsuario);
                // Crear un objeto ControlEntidad para la tabla de roles de usuario
				$objControlRolUsuario = new ControlEntidad('rol_usuario');
				
				// Llamar al método guardar con el objeto Entidad
				$objControlRolUsuario->guardar($objRolUsuario);
            }
		}
        header('Location: VistaUsuario.php');
		break;
    case 'Modificar':
        //1. modifica en tabla principal    
        $datosUsuario=['email' => $email, 'contrasena' => $contrasena];
        $objUsuario=new Entidad($datosUsuario);
        $objControlUsuario = new ControlEntidad('usuario');
        $objControlUsuario->modificar('email', $email, $objUsuario);

        //2. borrar todos los registros asociados de la tabla principal en la tabla intermedia
        $objControlRolUsuario = new ControlEntidad('rol_usuario');
        $objControlRolUsuario->borrar('fkemail',$email);

        //3. tomar del arreglo de roles los id y guardar los datos en la tabla intermedia
        if (!empty($roles_modal)) {
			foreach ($roles_modal as $key => $id) {
                $datosRolUsuario = ['fkemail' => $email, 'fkidrol' => $id];
                $objRolUsuario = new Entidad($datosRolUsuario);
                // Crear un objeto ControlEntidad para la tabla de roles de usuario
				$objControlRolUsuario = new ControlEntidad('rol_usuario');
				
				// Llamar al método guardar con el objeto Entidad
				$objControlRolUsuario->guardar($objRolUsuario);
            }
		}
        header('Location: VistaUsuario.php');
		break;
    case 'Eliminar':
        $objControlUsuario= new ControlEntidad('usuario');
        $objControlUsuario->borrar('email', $email);
        header('Location: vistaUsuario.php');
        break;

    default:
    // Lógica por defecto, si es necesaria
    break;
}

?>
<?php include 'header.html'; ?>
<?php include 'body.php'; ?>
<?php include 'modalLogin.php'; ?>

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
                        $registros_por_pagina = 5;
                        $total_registros = count($arregloUsuarios);
                        $total_paginas = ceil($total_registros / $registros_por_pagina);
                        $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                        $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                        $fin = $inicio + $registros_por_pagina;

                        for($i = $inicio; $i < $fin && $i < $total_registros; $i++){
                            $num_registro = $i + 1;
                            $getemail = $arregloUsuarios[$i]->__get('email');
                            $getcontrasena = $arregloUsuarios[$i]->__get('contrasena');
                            $objControlRolUsuario = new ControlEntidad('rol_usuario');
                            $sql = "SELECT fkidrol FROM rol_usuario WHERE fkemail = ?";
                            $parametros = [$getemail];
                            $arregloRolesConsulta = $objControlRolUsuario->consultar($sql, $parametros);
                            $idRolesString = '';
                            foreach ($arregloRolesConsulta as $objeto) {
                                $propiedades = $objeto->obtenerPropiedades(); // Suponiendo que tienes un método obtenerPropiedades en la clase Entidad
                                
                                if (isset($propiedades['fkidrol'])) {
                                    $fkidrol = $propiedades['fkidrol'];
                                    $idRolesString .= $fkidrol . ', '; // Agregar el id al string con una coma y un espacio
                                }
                            }
                            // Eliminar la última coma y espacio del string
                            $idRolesString = rtrim($idRolesString, ', ');
                            $nombreRolesString = '';
                            foreach ($arregloRolesConsulta as $objetoConsulta) {
                                $propiedadesConsulta = $objetoConsulta->obtenerPropiedades(); // Suponiendo que tienes un método obtenerPropiedades en la clase Entidad
                                
                                if (isset($propiedadesConsulta['fkidrol'])) {
                                    $fkidrolConsulta = $propiedadesConsulta['fkidrol'];
                                    
                                    foreach ($arregloRoles as $objetoRol) {
                                        $propiedadesRol = $objetoRol->obtenerPropiedades(); // Suponiendo que tienes un método obtenerPropiedades en la clase Entidad
                                        
                                        if (isset($propiedadesRol['id']) && $propiedadesRol['id'] == $fkidrolConsulta) {
                                            $nombreRolesString .= $propiedadesRol['nombre'] . ', ';
                                            break; // Salir del bucle interno una vez encontrado el rol
                                        }
                                    }
                                }
                            }

                            // Eliminar la última coma y espacio del string
                            $nombreRolesString = rtrim($nombreRolesString, ', ');
                        ?>
                            <tr>
                                <td><?= $num_registro ?></td>
                                <td><?= $getemail;?></td>
                                <td><?= $getcontrasena;?></td>
                                <td><?= $nombreRolesString  ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="post" action="VistaUsuario.php" enctype="multipart/form-data">
                                            <button type="button" class="btn btn-warning btn-sm btn-edit" name="modificar" data-bs-toggle="modal" data-bs-target="#editUser" data-bs-roles='<?= $idRolesString ?>' data-bs-email="<?= $getemail ?>" data-bs-pass="<?= $getcontrasena ?>"><i class="bi bi-pencil-square" style="font-size: 0.75rem;"></i></button>
                                        </form>
                                        <form method="post" action="VistaUsuario.php" enctype="multipart/form-data">
                                            <button type="button" class="btn btn-danger btn-sm" name="delete" data-bs-toggle="modal" data-bs-target="#deleteUser" data-bs-email="<?= $getemail ?>"><i class="bi bi-trash-fill" style="font-size: 0.75rem;"></i></button>
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
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de <b><?= $total_registros ?></b> usuarios</div>
                        <ul class="pagination">
                            <?php 
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaUsuario.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i=1; $i <= $total_paginas; $i++) { 
                                if($pagina_actual == $i){
                                    echo "<li class='page-item active'><a href='vistaUsuario.php?pagina=$i' class='page-link'>$i</a></li>";
                                }else{
                                    echo "<li class='page-item'><a href='vistaUsuario.php?pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaUsuario.php?pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
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
                            <input type="email" id="txtEmail" name="txtEmail" value="" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">**</span>
                            <input type="password" id="txtContrasena" name="txtContrasena" class="form-control" placeholder="Contraseña" aria-label="Contrasena" aria-describedby="basic-addon1" required>
                        </div>
                        <h5>Selecciona el rol:</h5>
                        <div class="container mt-3">
                            <?php for($i = 0; $i < count($arregloRoles); $i++){ 
                                $id = $arregloRoles[$i]->__get('id');
                                $nombre = $arregloRoles[$i]->__get('nombre');?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles_modal[<?= $id ?>]" value="<?= $id ?>" id="opcion<?= $id ?>_modal1">
                                    <label class="form-check-label" for="opcion<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="guardar">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" formmethod="post" name="bt" value="Guardar">Guardar</button>
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
                                <input type="email" id="txtEmail" name='txtEmail' value="" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" id="email" readonly>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">**</span>
                                <input type="password" id="txtContrasena" name='txtContrasena' class="form-control" placeholder="Contraseña" aria-label="Contrasena" aria-describedby="basic-addon1" id="contrasena">
                            </div>
                            <h5>Selecciona el rol:</h5>
                            <div class="container mt-3">
                            <?php for($i = 0; $i < count($arregloRoles); $i++){ 
                                $id = $arregloRoles[$i]->__get('id');
                                $nombre = $arregloRoles[$i]->__get('nombre');?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="roles_modal[<?= $id ?>]" value="<?= $id ?>" id="opcion<?= $id ?>_modal">
                                    <label class="form-check-label" for="opcion<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php }?>                      
                            </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="modificar">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt" value="Modificar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteUser" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="VistaUsuario.php" enctype="multipart/form-data">
                    <div class="modal-header">						
                        <h4 class="modal-title">Borrar Usuario</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">					
                        <p>Está seguro que desea eliminar este usuario?</p>
                        <p class="text-warning"><small>Ésta acción no se puede deshacer.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="txtEmail" value="" id="txtEmail">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt" id="confirmDelete" value="Eliminar" >Eliminar</button>
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
            const email = button.getAttribute('data-bs-email')
            const pass = button.getAttribute('data-bs-pass')
            const roles = button.getAttribute('data-bs-roles').split(',').map(Number) // Convertir a array de números
            
            
            const modalTitle = editUser.querySelector('.modal-title')
            const emailInput = editUser.querySelector('#txtEmail')
            const passInput = editUser.querySelector('#txtContrasena')
            const checkboxesContainer = editUser.querySelector('#checkboxes-container')
            
            modalTitle.textContent = `Modificar usuario ${email}`
            emailInput.value = email
            passInput.value = pass;

            // Resetear todos los checkboxes a falso
            document.querySelectorAll('.form-check-input').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Activar checks en base a fkidrol
            roles.forEach(rol => {
                const checkbox = document.getElementById(`opcion${rol}_modal`);
                if (checkbox) {
                    checkbox.checked = true
                }
            })



            // Validar checkboxes para el modal de editar usuario
            const checkboxesEdit = document.querySelectorAll('#editUser .form-check-input');
            const modifyButtonEdit = document.querySelector('#editUser [name="bt"][value="Modificar"]');

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
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = deleteUser.querySelector('.modal-title')
            const emailInput = deleteUser.querySelector('#txtEmail')
            
            modalTitle.textContent = `Eliminar usuario ${email}`
            emailInput.value = email
        })
    }

    // Validar checkboxes para el modal de agregar usuario
    const checkboxesAdd = document.querySelectorAll('#addUser .form-check-input');
    const saveButtonAdd = document.querySelector('#addUser [name="bt"][value="Guardar"]');

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


    // Función para ajustar el height del hero
    function ajustarAlturaHero() {
    var hero = document.getElementById('hero');
    var contenidoAltura = hero.scrollHeight; // Altura total del contenido del hero
    hero.style.height = contenidoAltura + 'px'; // Establecer la altura del hero
    }

    // Llamar a la función cuando se cargue la página y también cuando cambie el tamaño de la ventana
    window.addEventListener('load', ajustarAlturaHero);
    window.addEventListener('resize', ajustarAlturaHero);


</script>

<?php include 'footer.html'; ?>
<?php
  ob_end_flush();
?>