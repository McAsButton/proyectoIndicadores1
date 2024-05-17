<!-- Modal Login -->
<!-- Modal Form -->
<div class="modal fade" id="ModalLogin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title">Iniciar sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Username">Usuario<span class="text-danger">*</span></label>
                        <input type="text" name="txtLoginEmail" class="form-control" id="txtLoginEmail" placeholder="Ingrese Usuario">
                    </div>
                    <div class="mb-3">
                        <label for="Password">Contraseña<span class="text-danger">*</span></label>
                        <input type="password" name="txtLoginContrasena" class="form-control" id="txtLoginContrasena" placeholder="Ingrese Contraseña">
                    </div>
                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                        <a href="#" class="float-end">Olvide mi contraseña</a>
                    </div>
                </div>
                <div class="modal-footer pt-4">
                    <button type="submit" name="btnLogin" id="btnLogin" value="Login" class="btn btn-success mx-auto w-100">Iniciar Sesión</button>
                </div>
                <p class="text-center">No tienea una cuenta, <a href="#">Regístrate</a></p>
            </form>
        </div>
    </div>
</div>
<!-- Modal Login -->