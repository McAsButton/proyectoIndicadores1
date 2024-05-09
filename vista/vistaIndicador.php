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

// Establecer la zona horaria a la local del servidor
date_default_timezone_set('America/Bogota');

$objControlIndicador = new ControlEntidad('indicador');
$arregloIndicadores = $objControlIndicador->listar();
$objControlTipoIndicador = new ControlEntidad('tipoindicador');
$arregloTipoIndicador = $objControlTipoIndicador->listar();
$objControlUnidadMedicion = new ControlEntidad('unidadmedicion');
$arregloUnidadMedicion = $objControlUnidadMedicion->listar();
$objControlSentido = new ControlEntidad('sentido');
$arregloSentido = $objControlSentido->listar();
$objControlFrecuencia = new ControlEntidad('frecuencia');
$arregloFrecuencia = $objControlFrecuencia->listar();
$objControlArticulo = new ControlEntidad('articulo');
$arregloArticulo = $objControlArticulo->listar();
$objControlLiteral = new ControlEntidad('literal');
$arregloLiteral = $objControlLiteral->listar();
$objControlNumeral = new ControlEntidad('numeral');
$arregloNumeral = $objControlNumeral->listar();
$objControlParagrafo = new ControlEntidad('paragrafo');
$arregloParagrafo = $objControlParagrafo->listar();
$objControlRepresenVisual = new ControlEntidad('represenvisual');
$arregloRepresenVisual = $objControlRepresenVisual->listar();
$objControlActor = new ControlEntidad('actor');
$arregloActor = $objControlActor->listar();
$objControlFuente = new ControlEntidad('fuente');
$arregloFuente = $objControlFuente->listar();
$objControlVariable = new ControlEntidad('variable');
$arregloVariable = $objControlVariable->listar();

$boton = $_POST['bt'] ?? ''; // Captura el valor del botón
$id = $_POST['txtId'] ?? ''; // Captura el valor del campo Id
$codigo = $_POST['txtCodigo'] ?? ''; // Captura el valor del campo Codigo
$nombre = $_POST['txtNombre'] ?? ''; // Captura el valor del campo Nombre
$objetivo = $_POST['txtObjetivo'] ?? ''; // Captura el valor del campo Objetivo
$alcance = $_POST['txtAlcance'] ?? ''; // Captura el valor del campo Alcance
$formula = $_POST['txtFormula'] ?? ''; // Captura el valor del campo Formula
$tipoIndicador = $_POST['txtTipoIndicador'] ?? ''; // Captura el valor del campo Tipo de Indicador
$unidadMedicion = $_POST['txtUnidadMedicion'] ?? ''; // Captura el valor del campo Unidad de Medición
$meta = $_POST['txtMeta'] ?? ''; // Captura el valor del campo Meta
$sentido = $_POST['txtSentido'] ?? ''; // Captura el valor del campo Sentido
$frecuencia = $_POST['txtFrecuencia'] ?? ''; // Captura el valor del campo Frecuencia
$articulo = $_POST['txtArticulo'] ?? ''; // Captura el valor del campo Articulo
$literal = $_POST['txtLiteral'] ?? ''; // Captura el valor del campo Literal
$numeral = $_POST['txtNumeral'] ?? ''; // Captura el valor del campo Numeral
$paragrafo = $_POST['txtParagrafo'] ?? ''; // Captura el valor del campo Paragrafo
$represenVisual = $_POST['represen_modal'] ?? []; // Captura el valor del campo Representacion Visual
$actor = $_POST['actores_modal'] ?? []; // Captura el valor del campo Actor
$fuente = $_POST['fuentes_modal'] ?? []; // Captura el valor del campo Fuente
$variable = $_POST['variables_modal'] ?? []; // Captura el valor del campo Variable
$fecha_y_hora = date("Y-m-d H:i:s");
$consultarId = $_POST['txtConsultarId'] ?? ''; // Captura el valor del campo Consultar Id

switch ($boton) {
    case 'Guardar':
        try {
            $datosIndicador = ['codigo' => $codigo, 'nombre' => $nombre, 'objetivo' => $objetivo, 'alcance' => $alcance, 'formula' => $formula, 'fkidtipoindicador' => $tipoIndicador, 'fkidunidadmedicion' => $unidadMedicion, 'meta' => $meta, 'fkidsentido' => $sentido, 'fkidfrecuencia' => $frecuencia, 'fkidarticulo' => $articulo, 'fkidliteral' => $literal, 'fkidnumeral' => $numeral, 'fkidparagrafo' => $paragrafo];
            $objIndicador = new Entidad($datosIndicador);
            $objControlIndicador = new ControlEntidad('indicador');
            $objControlIndicador->guardar($objIndicador);
            $sql = 'SELECT id FROM indicador WHERE codigo = ? AND nombre = ? AND objetivo = ? AND alcance = ? AND formula = ? AND fkidtipoindicador = ? AND fkidunidadmedicion = ? AND meta = ? AND fkidsentido = ? AND fkidfrecuencia = ? AND fkidarticulo = ? AND fkidliteral = ? AND fkidnumeral = ? AND fkidparagrafo = ?';
            $parametros = [$codigo, $nombre, $objetivo, $alcance, $formula, intval($tipoIndicador), intval($unidadMedicion), $meta, intval($sentido), intval($frecuencia), $articulo, $literal, $numeral, $paragrafo];
            $arregloIdIndicador = $objControlIndicador->consultar($sql, $parametros);
            $idIndicador = $arregloIdIndicador[0]->__get('id');

            if (!empty($represenVisual)) {
                foreach ($represenVisual as $key => $value) {
                    $datosRepresenVisualPorIndicador = ['fkidindicador' => $idIndicador, 'fkidrepresenvisual' => $value];
                    $objRepresenVisualPorIndicador = new Entidad($datosRepresenVisualPorIndicador);
                    $objControlRepresenVisualPorIndicador = new ControlEntidad('represenvisualporindicador');
                    $objControlRepresenVisualPorIndicador->guardar($objRepresenVisualPorIndicador);
                }
            }

            if (!empty($actor)) {
                foreach ($actor as $key => $value) {
                    $datosActorPorIndicador = ['fkidresponsable' => $value, 'fkidindicador' => $idIndicador, 'fechaasignacion' => $fecha_y_hora];
                    $objActorPorIndicador = new Entidad($datosActorPorIndicador);
                    $objControlActorPorIndicador = new ControlEntidad('responsablesporindicador');
                    $objControlActorPorIndicador->guardar($objActorPorIndicador);
                }
            }

            if (!empty($fuente)) {
                foreach ($fuente as $key => $value) {
                    $datosFuentePorIndicador = ['fkidfuente' => $value, 'fkidindicador' => $idIndicador];
                    $objFuentePorIndicador = new Entidad($datosFuentePorIndicador);
                    $objControlFuentePorIndicador = new ControlEntidad('fuentesporindicador');
                    $objControlFuentePorIndicador->guardar($objFuentePorIndicador);
                }
            }

            if (!empty($variable)) {
                foreach ($variable as $key => $value) {
                    $datosVariablePorIndicador = ['fkidvariable' => $value, 'fkidindicador' => $idIndicador, 'dato' => '0', 'fkemailusuario' => $_SESSION['email'], 'fechadato' => $fecha_y_hora];
                    $objVariablePorIndicador = new Entidad($datosVariablePorIndicador);
                    $objControlVariablePorIndicador = new ControlEntidad('variablesporindicador');
                    $objControlVariablePorIndicador->guardar($objVariablePorIndicador);
                }
            }

            header('Location: VistaIndicador.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: VistaIndicador.php?spawnNote=0');
        }
        break;
    case 'Consultar':
        try {
            $datosIndicador = ['id' => $consultarId];
            $objIndicador = new Entidad($datosIndicador);
            $objControlIndicador = new ControlEntidad('indicador');
            $objIndicador = $objControlIndicador->buscarPorId('id', $consultarId);

            if ($objIndicador !== null) {
                $id = $objIndicador->__get('id');
                $codigo = $objIndicador->__get('codigo');
                $nombre = $objIndicador->__get('nombre');
                $objetivo = $objIndicador->__get('objetivo');
                $alcance = $objIndicador->__get('alcance');
                $formula = $objIndicador->__get('formula');
                $tipoIndicador = $objIndicador->__get('fkidtipoindicador');
                $unidadMedicion = $objIndicador->__get('fkidunidadmedicion');
                $meta = $objIndicador->__get('meta');
                $sentido = $objIndicador->__get('fkidsentido');
                $frecuencia = $objIndicador->__get('fkidfrecuencia');
                $articulo = $objIndicador->__get('fkidarticulo');
                $literal = $objIndicador->__get('fkidliteral');
                $numeral = $objIndicador->__get('fkidnumeral');
                $paragrafo = $objIndicador->__get('fkidparagrafo');

                $objControlRepresenVisualPorIndicador = new ControlEntidad('represenvisualporindicador');
                $sql = "SELECT fkidrepresenvisual FROM represenvisualporindicador WHERE fkidindicador = ?";
                $parametros = [$id];
                $arregloRepresenVisualPorIndicador = $objControlRepresenVisualPorIndicador->consultar($sql, $parametros);
                $idRepresenVisual = [];
                foreach ($arregloRepresenVisualPorIndicador as $objeto) {
                    $propiedades = $objeto->obtenerPropiedades();
                    if (isset($propiedades['fkidrepresenvisual'])) {
                        $idRepresenVisual[] = $propiedades['fkidrepresenvisual'];
                    }
                }
                $idRepresenVisualString = implode(',', $idRepresenVisual);
                $represenVisualParam = json_encode($idRepresenVisual);

                $objControlActorPorIndicador = new ControlEntidad('responsablesporindicador');
                $sql = "SELECT fkidresponsable FROM responsablesporindicador WHERE fkidindicador = ?";
                $parametros = [$id];
                $arregloActorPorIndicador = $objControlActorPorIndicador->consultar($sql, $parametros);
                $idActor = [];
                foreach ($arregloActorPorIndicador as $objeto) {
                    $propiedades = $objeto->obtenerPropiedades();
                    if (isset($propiedades['fkidresponsable'])) {
                        $idActor[] = $propiedades['fkidresponsable'];
                    }
                }
                $idActorString = implode(',', $idActor);
                $actorParam = json_encode($idActor);

                $objControlFuentePorIndicador = new ControlEntidad('fuentesporindicador');
                $sql = "SELECT fkidfuente FROM fuentesporindicador WHERE fkidindicador = ?";
                $parametros = [$id];
                $arregloFuentePorIndicador = $objControlFuentePorIndicador->consultar($sql, $parametros);
                $idFuente = [];
                foreach ($arregloFuentePorIndicador as $objeto) {
                    $propiedades = $objeto->obtenerPropiedades();
                    if (isset($propiedades['fkidfuente'])) {
                        $idFuente[] = $propiedades['fkidfuente'];
                    }
                }
                $idFuenteString = implode(',', $idFuente);
                $fuenteParam = json_encode($idFuente);

                $objControlVariablePorIndicador = new ControlEntidad('variablesporindicador');
                $sql = "SELECT fkidvariable FROM variablesporindicador WHERE fkidindicador = ?";
                $parametros = [$id];
                $arregloVariablePorIndicador = $objControlVariablePorIndicador->consultar($sql, $parametros);
                $idVariable = [];
                foreach ($arregloVariablePorIndicador as $objeto) {
                    $propiedades = $objeto->obtenerPropiedades();
                    if (isset($propiedades['fkidvariable'])) {
                        $idVariable[] = $propiedades['fkidvariable'];
                    }
                }
                $idVariableString = implode(',', $idVariable);
                $variableParam = json_encode($idVariable);
                header('Location: VistaIndicador.php?id=' . $id . '&codigo=' . $codigo . '&nombre=' . $nombre . '&objetivo=' . $objetivo . '&alcance=' . $alcance . '&formula=' . $formula . '&tipoIndicador=' . $tipoIndicador . '&unidadMedicion=' . $unidadMedicion . '&meta=' . $meta . '&sentido=' . $sentido . '&frecuencia=' . $frecuencia . '&articulo=' . $articulo . '&literal=' . $literal . '&numeral=' . $numeral . '&paragrafo=' . $paragrafo . '&represenVisual=' . urlencode($represenVisualParam) . '&actor=' . urlencode($actorParam) . '&fuente=' . urlencode($fuenteParam) . '&variable=' . urlencode($variableParam));
            } else {
                header('Location: VistaIndicador.php?spawnNote=0');
            }
        } catch (Exception $e) {
            header('Location: VistaIndicador.php?spawnNote=0');
        }
        break;
    case 'Modificar':
        try {
            //1. modifica en tabla principal
            $datosIndicador = ['codigo' => $codigo, 'nombre' => $nombre, 'objetivo' => $objetivo, 'alcance' => $alcance, 'formula' => $formula, 'fkidtipoindicador' => $tipoIndicador, 'fkidunidadmedicion' => $unidadMedicion, 'meta' => $meta, 'fkidsentido' => $sentido, 'fkidfrecuencia' => $frecuencia, 'fkidarticulo' => $articulo, 'fkidliteral' => $literal, 'fkidnumeral' => $numeral, 'fkidparagrafo' => $paragrafo];
            $objIndicador = new Entidad($datosIndicador);
            $objControlIndicador = new ControlEntidad('indicador');
            $objControlIndicador->modificar('id', $id, $objIndicador);

            //2. borrar todos los registros asociados de la tabla principal en las tablas intermedias
            $objControlRepresenVisualPorIndicador = new ControlEntidad('represenvisualporindicador');
            $objControlRepresenVisualPorIndicador->borrar('fkidindicador', $id);
            $objControlActorPorIndicador = new ControlEntidad('responsablesporindicador');
            $objControlActorPorIndicador->borrar('fkidindicador', $id);
            $objControlFuentePorIndicador = new ControlEntidad('fuentesporindicador');
            $objControlFuentePorIndicador->borrar('fkidindicador', $id);
            $objControlVariablePorIndicador = new ControlEntidad('variablesporindicador');
            $objControlVariablePorIndicador->borrar('fkidindicador', $id);

            //3. insertar los nuevos registros asociados de la tabla principal en las tablas intermedias
            if (!empty($represenVisual)) {
                foreach ($represenVisual as $key => $value) {
                    $datosRepresenVisualPorIndicador = ['fkidindicador' => $id, 'fkidrepresenvisual' => $value];
                    $objRepresenVisualPorIndicador = new Entidad($datosRepresenVisualPorIndicador);
                    $objControlRepresenVisualPorIndicador = new ControlEntidad('represenvisualporindicador');
                    $objControlRepresenVisualPorIndicador->guardar($objRepresenVisualPorIndicador);
                }
            }

            if (!empty($actor)) {
                foreach ($actor as $key => $value) {
                    $datosActorPorIndicador = ['fkidresponsable' => $value, 'fkidindicador' => $id, 'fechaasignacion' => $fecha_y_hora];
                    $objActorPorIndicador = new Entidad($datosActorPorIndicador);
                    $objControlActorPorIndicador = new ControlEntidad('responsablesporindicador');
                    $objControlActorPorIndicador->guardar($objActorPorIndicador);
                }
            }

            if (!empty($fuente)) {
                foreach ($fuente as $key => $value) {
                    $datosFuentePorIndicador = ['fkidfuente' => $value, 'fkidindicador' => $id];
                    $objFuentePorIndicador = new Entidad($datosFuentePorIndicador);
                    $objControlFuentePorIndicador = new ControlEntidad('fuentesporindicador');
                    $objControlFuentePorIndicador->guardar($objFuentePorIndicador);
                }
            }

            if (!empty($variable)) {
                foreach ($variable as $key => $value) {
                    $datosVariablePorIndicador = ['fkidvariable' => $value, 'fkidindicador' => $id, 'dato' => '0', 'fkemailusuario' => $_SESSION['email'], 'fechadato' => $fecha_y_hora];
                    $objVariablePorIndicador = new Entidad($datosVariablePorIndicador);
                    $objControlVariablePorIndicador = new ControlEntidad('variablesporindicador');
                    $objControlVariablePorIndicador->guardar($objVariablePorIndicador);
                }
            }
            header('Location: VistaIndicador.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: VistaIndicador.php?spawnNote=0');
        }
        break;
    case 'Eliminar':
        try {
            $objControlIndicador = new ControlEntidad('indicador');
            $objControlIndicador->borrar('id', $id);
            header('Location: VistaIndicador.php?spawnNote=1');
        } catch (Exception $e) {
            header('Location: VistaIndicador.php?spawnNote=0');
        }
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
                        <div class="row d-flex align-items-center justify-content-center">
                            <div class="col-sm">
                                <h2><b>Administrar</b> Indicadores</h2>
                            </div>
                            <div class="col-sm">
                                <form class="d-flex" method="post" action="VistaIndicador.php">
                                    <input class="form-control mr-2 mb-1" type="search" placeholder="Buscar id"
                                        aria-label="Search" id="txtConsultarId" name="txtConsultarId">
                                    <button class="btn btn-outline-success" type="submit" formmethod="post" name="bt"
                                        value="Consultar"><i class="bi bi-search"></i></button>
                                </form>
                            </div>
                            <div class="col-sm">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addIndicador"><i class="bi bi-person-plus"></i><span>Nuevo
                                        Indicador</span></button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-responsive-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Id</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Objetivo</th>
                                <th>Alcance</th>
                                <th>Formula</th>
                                <th>Tipo de Indicador</th>
                                <th>Unidad de Medición</th>
                                <th>Meta</th>
                                <th>Sentido</th>
                                <th>Frecuencia</th>
                                <th>Articulo</th>
                                <th>Literal</th>
                                <th>Numeral</th>
                                <th>Paragrafo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $registros_por_pagina = 5;
                            $total_registros = count($arregloIndicadores);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $num_registro = $i + 1;
                                $getid = $arregloIndicadores[$i]->__get('id');
                                $getcodigo = $arregloIndicadores[$i]->__get('codigo');
                                $getnombre = $arregloIndicadores[$i]->__get('nombre');
                                $getobjetivo = $arregloIndicadores[$i]->__get('objetivo');
                                $getalcance = $arregloIndicadores[$i]->__get('alcance');
                                $getformula = $arregloIndicadores[$i]->__get('formula');

                                $tipoIndicador = $arregloIndicadores[$i]->__get('fkidtipoindicador');
                                $objControlTipoIndicador = new ControlEntidad('tipoindicador');
                                $sql = "SELECT * FROM tipoindicador WHERE id = ?";
                                $parametros = [$tipoIndicador];
                                $arreglotipoIndicadorConsulta = $objControlTipoIndicador->consultar($sql, $parametros);
                                $gettipoIndicador = $arreglotipoIndicadorConsulta[0]->__get('nombre');
                                $getIdTipoIndicador = $arreglotipoIndicadorConsulta[0]->__get('id');

                                $unidadMedicion = $arregloIndicadores[$i]->__get('fkidunidadmedicion');
                                $objControlUnidadMedicion = new ControlEntidad('unidadmedicion');
                                $sql = "SELECT * FROM unidadmedicion WHERE id = ?";
                                $parametros = [$unidadMedicion];
                                $arregloUnidadMedicionConsulta = $objControlUnidadMedicion->consultar($sql, $parametros);
                                $getunidadMedicion = $arregloUnidadMedicionConsulta[0]->__get('descripcion');
                                $getIdUnidadMedicion = $arregloUnidadMedicionConsulta[0]->__get('id');

                                $getmeta = $arregloIndicadores[$i]->__get('meta');

                                $sentido = $arregloIndicadores[$i]->__get('fkidsentido');
                                $objControlSentido = new ControlEntidad('sentido');
                                $sql = "SELECT * FROM sentido WHERE id = ?";
                                $parametros = [$sentido];
                                $arregloSentidoConsulta = $objControlSentido->consultar($sql, $parametros);
                                $getsentido = $arregloSentidoConsulta[0]->__get('nombre');
                                $getIdSentido = $arregloSentidoConsulta[0]->__get('id');

                                $frecuencia = $arregloIndicadores[$i]->__get('fkidfrecuencia');
                                $objControlFrecuencia = new ControlEntidad('frecuencia');
                                $sql = "SELECT * FROM frecuencia WHERE id = ?";
                                $parametros = [$frecuencia];
                                $arregloFrecuenciaConsulta = $objControlFrecuencia->consultar($sql, $parametros);
                                $getfrecuencia = $arregloFrecuenciaConsulta[0]->__get('nombre');
                                $getIdFrecuencia = $arregloFrecuenciaConsulta[0]->__get('id');

                                $articulo = $arregloIndicadores[$i]->__get('fkidarticulo');
                                $objControlArticulo = new ControlEntidad('articulo');
                                $sql = "SELECT nombre FROM articulo WHERE id = ?";
                                $parametros = [$articulo];
                                $arregloArticuloConsulta = $objControlArticulo->consultar($sql, $parametros);
                                $getarticulo = $arregloArticuloConsulta[0]->__get('nombre');

                                $literal = $arregloIndicadores[$i]->__get('fkidliteral');
                                $objControlLiteral = new ControlEntidad('literal');
                                $sql = "SELECT descripcion FROM literal WHERE id = ?";
                                $parametros = [$literal];
                                $arregloLiteralConsulta = $objControlLiteral->consultar($sql, $parametros);
                                $getliteral = $arregloLiteralConsulta[0]->__get('descripcion');

                                $numeral = $arregloIndicadores[$i]->__get('fkidnumeral');
                                $objControlNumeral = new ControlEntidad('numeral');
                                $sql = "SELECT descripcion FROM numeral WHERE id = ?";
                                $parametros = [$numeral];
                                $arregloNumeralConsulta = $objControlNumeral->consultar($sql, $parametros);
                                $getnumeral = $arregloNumeralConsulta[0]->__get('descripcion');

                                $paragrafo = $arregloIndicadores[$i]->__get('fkidparagrafo');
                                $objControlParagrafo = new ControlEntidad('paragrafo');
                                $sql = "SELECT descripcion FROM paragrafo WHERE id = ?";
                                $parametros = [$paragrafo];
                                $arregloParagrafoConsulta = $objControlParagrafo->consultar($sql, $parametros);
                                $getparagrafo = $arregloParagrafoConsulta[0]->__get('descripcion');

                                $objControlRepresenVisualPorIndicador = new ControlEntidad('represenvisualporindicador');
                                $sql = "SELECT fkidrepresenvisual FROM represenvisualporindicador WHERE fkidindicador = ?";
                                $parametros = [$getid];
                                $arregloRepresenVisualPorIndicador = $objControlRepresenVisualPorIndicador->consultar($sql, $parametros);
                                $idRepresenVisualString = '';
                                foreach ($arregloRepresenVisualPorIndicador as $objeto) {
                                    $propiedades = $objeto->obtenerPropiedades();
                                    if (isset($propiedades['fkidrepresenvisual'])) {
                                        $idRepresenVisual = $propiedades['fkidrepresenvisual'];
                                        $idRepresenVisualString .= $idRepresenVisual . ', ';
                                    }
                                }

                                $objControlActorPorIndicador = new ControlEntidad('responsablesporindicador');
                                $sql = "SELECT fkidresponsable FROM responsablesporindicador WHERE fkidindicador = ?";
                                $parametros = [$getid];
                                $arregloActorPorIndicador = $objControlActorPorIndicador->consultar($sql, $parametros);
                                $idActorString = '';
                                foreach ($arregloActorPorIndicador as $objeto) {
                                    $propiedades = $objeto->obtenerPropiedades();
                                    if (isset($propiedades['fkidresponsable'])) {
                                        $idActor = $propiedades['fkidresponsable'];
                                        $idActorString .= $idActor . ', ';
                                    }
                                }

                                $objControlFuentePorIndicador = new ControlEntidad('fuentesporindicador');
                                $sql = "SELECT fkidfuente FROM fuentesporindicador WHERE fkidindicador = ?";
                                $parametros = [$getid];
                                $arregloFuentePorIndicador = $objControlFuentePorIndicador->consultar($sql, $parametros);
                                $idFuenteString = '';
                                foreach ($arregloFuentePorIndicador as $objeto) {
                                    $propiedades = $objeto->obtenerPropiedades();
                                    if (isset($propiedades['fkidfuente'])) {
                                        $idFuente = $propiedades['fkidfuente'];
                                        $idFuenteString .= $idFuente . ', ';
                                    }
                                }

                                $objControlVariablePorIndicador = new ControlEntidad('variablesporindicador');
                                $sql = "SELECT fkidvariable FROM variablesporindicador WHERE fkidindicador = ?";
                                $parametros = [$getid];
                                $arregloVariablePorIndicador = $objControlVariablePorIndicador->consultar($sql, $parametros);
                                $idVariableString = '';
                                foreach ($arregloVariablePorIndicador as $objeto) {
                                    $propiedades = $objeto->obtenerPropiedades();
                                    if (isset($propiedades['fkidvariable'])) {
                                        $idVariable = $propiedades['fkidvariable'];
                                        $idVariableString .= $idVariable . ', ';
                                    }
                                }
                                ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $getid ?></td>
                                    <td><?= $getcodigo ?></td>
                                    <td><?= $getnombre ?></td>
                                    <td><?= $getobjetivo ?></td>
                                    <td><?= $getalcance ?></td>
                                    <td><?= $getformula ?></td>
                                    <td><?= $gettipoIndicador ?></td>
                                    <td><?= $getunidadMedicion ?></td>
                                    <td><?= $getmeta ?></td>
                                    <td><?= $getsentido ?></td>
                                    <td><?= $getfrecuencia ?></td>
                                    <td><?= $articulo ?></td>
                                    <td><?= $literal ?></td>
                                    <td><?= $numeral ?></td>
                                    <td><?= $paragrafo ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form method="post" action="VistaIndicador.php" enctype="multipart/form-data">
                                                <button type="button" class="btn btn-warning btn-sm btn-edit botonModificar"
                                                    name="modificar" data-bs-toggle="modal" data-bs-target="#editIndicador"
                                                    data-bs-id="<?= $getid ?>" data-bs-codigo="<?= $getcodigo ?>"
                                                    data-bs-nombre="<?= $getnombre ?>"
                                                    data-bs-objetivo="<?= $getobjetivo ?>"
                                                    data-bs-alcance="<?= $getalcance ?>"
                                                    data-bs-formula="<?= $getformula ?>"
                                                    data-bs-tipoIndicador="<?= $getIdTipoIndicador ?>"
                                                    data-bs-unidadMedicion="<?= $getIdUnidadMedicion ?>"
                                                    data-bs-meta="<?= $getmeta ?>" data-bs-sentido="<?= $getIdSentido ?>"
                                                    data-bs-frecuencia="<?= $getIdFrecuencia ?>"
                                                    data-bs-articulo="<?= $articulo ?>" data-bs-literal="<?= $literal ?>"
                                                    data-bs-numeral="<?= $numeral ?>" data-bs-paragrafo="<?= $paragrafo ?>"
                                                    data-bs-represenvisual="<?= $idRepresenVisualString ?>"
                                                    data-bs-actores="<?= $idActorString ?>"
                                                    data-bs-fuentes="<?= $idFuenteString ?>"
                                                    data-bs-variables="<?= $idVariableString ?>"><i
                                                        class="bi bi-pencil-square"
                                                        style="font-size: 0.75rem;"></i></button>
                                            </form>
                                            <form method="post" action="VistaIndicador.php" enctype="multipart/form-data">
                                                <button type="button" class="btn btn-danger btn-sm" name="delete"
                                                    data-bs-toggle="modal" data-bs-target="#deleteIndicador"
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
                            <b><?= $total_registros ?></b> usuarios
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaUsuario.php?pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaUsuario.php?pagina=$i' class='page-link'>$i</a></li>";
                                } else {
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
</section>

<main id="main">
    <!-- Add Modal HTML -->
    <div class="modal fade" id="addIndicador" tabindex="-1" aria-labelledby="addIndicador" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaIndicador.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Indicador</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" id="txtCodigo" name="txtCodigo" value="" class="form-control"
                                placeholder="Codigo" aria-label="Codigo" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" id="txtNombre" name="txtNombre" value="" class="form-control"
                                placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <textarea id="txtObjetivo" name="txtObjetivo" value="" class="form-control"
                                placeholder="Objetivo" aria-label="Objetivo" aria-describedby="basic-addon1"
                                required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <textarea id="txtAlcance" name="txtAlcance" value="" class="form-control"
                                placeholder="Alcance" aria-label="Alcance" aria-describedby="basic-addon1"
                                required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" id="txtFormula" name="txtFormula" value="" class="form-control"
                                placeholder="Formula" aria-label="Formula" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtTipoIndicador" name="txtTipoIndicador" required>
                                <option selected disabled value="">Tipo de Indicador</option>
                                <?php
                                for ($i = 0; $i < count($arregloTipoIndicador); $i++) {
                                    $id = $arregloTipoIndicador[$i]->__get('id');
                                    $nombre = $arregloTipoIndicador[$i]->__get('nombre');
                                    echo "<option value='$id'>$nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtUnidadMedicion" name="txtUnidadMedicion" required>
                                <option selected disabled value="">Unidad de Medición</option>
                                <?php
                                for ($i = 0; $i < count($arregloUnidadMedicion); $i++) {
                                    $id = $arregloUnidadMedicion[$i]->__get('id');
                                    $descripcion = $arregloUnidadMedicion[$i]->__get('descripcion');
                                    echo "<option value='$id'>$descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <textarea id="txtMeta" name="txtMeta" value="" class="form-control" placeholder="Meta"
                                aria-label="Meta" aria-describedby="basic-addon1" required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtSentido" name="txtSentido" required>
                                <option selected disabled value="">Sentido</option>
                                <?php
                                for ($i = 0; $i < count($arregloSentido); $i++) {
                                    $id = $arregloSentido[$i]->__get('id');
                                    $nombre = $arregloSentido[$i]->__get('nombre');
                                    echo "<option value='$id'>$nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtFrecuencia" name="txtFrecuencia" required>
                                <option selected disabled value="">Frecuencia</option>
                                <?php
                                for ($i = 0; $i < count($arregloFrecuencia); $i++) {
                                    $id = $arregloFrecuencia[$i]->__get('id');
                                    $nombre = $arregloFrecuencia[$i]->__get('nombre');
                                    echo "<option value='$id'>$nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtArticulo" name="txtArticulo" required>
                                <option selected disabled value="">Articulo</option>
                                <?php
                                for ($i = 0; $i < count($arregloArticulo); $i++) {
                                    $id = $arregloArticulo[$i]->__get('id');
                                    $nombre = $arregloArticulo[$i]->__get('nombre');
                                    echo "<option value='$id'>$nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtLiteral" name="txtLiteral" required>
                                <option selected disabled value="">Literal</option>
                                <?php
                                for ($i = 0; $i < count($arregloLiteral); $i++) {
                                    $id = $arregloLiteral[$i]->__get('id');
                                    $descripcion = $arregloLiteral[$i]->__get('descripcion');
                                    echo "<option value='$id'>$descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtNumeral" name="txtNumeral" required>
                                <option selected disabled value="">Numeral</option>
                                <?php
                                for ($i = 0; $i < count($arregloNumeral); $i++) {
                                    $id = $arregloNumeral[$i]->__get('id');
                                    $descripcion = $arregloNumeral[$i]->__get('descripcion');
                                    echo "<option value='$id'>$descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtParagrafo" name="txtParagrafo" required>
                                <option selected disabled value="">Paragrafo</option>
                                <?php
                                for ($i = 0; $i < count($arregloParagrafo); $i++) {
                                    $id = $arregloParagrafo[$i]->__get('id');
                                    $descripcion = $arregloParagrafo[$i]->__get('descripcion');
                                    echo "<option value='$id'>$descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <h5>Selecciona las Representaciones Visuales:</h5>
                        <div class="container mt-3">
                            <?php for ($i = 0; $i < count($arregloRepresenVisual); $i++) {
                                $id = $arregloRepresenVisual[$i]->__get('id');
                                $nombre = $arregloRepresenVisual[$i]->__get('nombre'); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="represen_modal[<?= $id ?>]"
                                        value="<?= $id ?>" id="opcion<?= $id ?>_modal">
                                    <label class="form-check-label" for="opcion<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <h5>Selecciona los responsables:</h5>
                        <div class="container mt-3">
                            <?php for ($i = 0; $i < count($arregloActor); $i++) {
                                $id = $arregloActor[$i]->__get('id');
                                $nombre = $arregloActor[$i]->__get('nombre'); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="actores_modal[<?= $id ?>]"
                                        value="<?= $id ?>" id="opcion<?= $id ?>_modal">
                                    <label class="form-check-label" for="opcion<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <h5>Selecciona las Fuentes:</h5>
                        <div class="container mt-3">
                            <?php for ($i = 0; $i < count($arregloFuente); $i++) {
                                $id = $arregloFuente[$i]->__get('id');
                                $nombre = $arregloFuente[$i]->__get('nombre'); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fuentes_modal[<?= $id ?>]"
                                        value="<?= $id ?>" id="opcion<?= $id ?>_modal">
                                    <label class="form-check-label" for="opcion<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <h5>Selecciona las Variables:</h5>
                        <div class="container mt-3">
                            <?php for ($i = 0; $i < count($arregloVariable); $i++) {
                                $id = $arregloVariable[$i]->__get('id');
                                $nombre = $arregloVariable[$i]->__get('nombre'); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="variables_modal[<?= $id ?>]"
                                        value="<?= $id ?>" id="opcion<?= $id ?>_modal">
                                    <label class="form-check-label" for="opcion<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="guardar">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" formmethod="post" name="bt"
                            value="Guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal HTML -->
    <div class="modal fade" id="editIndicador" tabindex="-1" aria-labelledby="editIndicador" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="VistaIndicador.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar Indicador</h1>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3" hidden>
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" id="txtId" name="txtId" value="" class="form-control" placeholder="Id"
                                aria-label="Id" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" id="txtCodigo" name="txtCodigo" value="" class="form-control"
                                placeholder="Codigo" aria-label="Codigo" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" id="txtNombre" name="txtNombre" value="" class="form-control"
                                placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <textarea id="txtObjetivo" name="txtObjetivo" value="" class="form-control"
                                placeholder="Objetivo" aria-label="Objetivo" aria-describedby="basic-addon1"
                                required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <textarea id="txtAlcance" name="txtAlcance" value="" class="form-control"
                                placeholder="Alcance" aria-label="Alcance" aria-describedby="basic-addon1"
                                required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <input type="text" id="txtFormula" name="txtFormula" value="" class="form-control"
                                placeholder="Formula" aria-label="Formula" aria-describedby="basic-addon1" required>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtTipoIndicador" name="txtTipoIndicador" required>
                                <option selected disabled value="">Tipo de Indicador</option>
                                <?php
                                for ($i = 0; $i < count($arregloTipoIndicador); $i++) {
                                    $id = $arregloTipoIndicador[$i]->__get('id');
                                    $nombre = $arregloTipoIndicador[$i]->__get('nombre');
                                    echo "<option value='$id'>$nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtUnidadMedicion" name="txtUnidadMedicion" required>
                                <option selected disabled value="">Unidad de Medición</option>
                                <?php
                                for ($i = 0; $i < count($arregloUnidadMedicion); $i++) {
                                    $id = $arregloUnidadMedicion[$i]->__get('id');
                                    $descripcion = $arregloUnidadMedicion[$i]->__get('descripcion');
                                    echo "<option value='$id'>$descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">A</span>
                            <textarea id="txtMeta" name="txtMeta" value="" class="form-control" placeholder="Meta"
                                aria-label="Meta" aria-describedby="basic-addon1" required></textarea>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtSentido" name="txtSentido" required>
                                <option selected disabled value="">Sentido</option>
                                <?php
                                for ($i = 0; $i < count($arregloSentido); $i++) {
                                    $id = $arregloSentido[$i]->__get('id');
                                    $nombre = $arregloSentido[$i]->__get('nombre');
                                    echo "<option value='$id'>$nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtFrecuencia" name="txtFrecuencia" required>
                                <option selected disabled value="">Frecuencia</option>
                                <?php
                                for ($i = 0; $i < count($arregloFrecuencia); $i++) {
                                    $id = $arregloFrecuencia[$i]->__get('id');
                                    $nombre = $arregloFrecuencia[$i]->__get('nombre');
                                    echo "<option value='$id'>$nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtArticulo" name="txtArticulo" required>
                                <option selected disabled value="">Articulo</option>
                                <?php
                                for ($i = 0; $i < count($arregloArticulo); $i++) {
                                    $id = $arregloArticulo[$i]->__get('id');
                                    $nombre = $arregloArticulo[$i]->__get('nombre');
                                    echo "<option value='$id'>$nombre</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtLiteral" name="txtLiteral" required>
                                <option selected disabled value="">Literal</option>
                                <?php
                                for ($i = 0; $i < count($arregloLiteral); $i++) {
                                    $id = $arregloLiteral[$i]->__get('id');
                                    $descripcion = $arregloLiteral[$i]->__get('descripcion');
                                    echo "<option value='$id'>$descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtNumeral" name="txtNumeral" required>
                                <option selected disabled value="">Numeral</option>
                                <?php
                                for ($i = 0; $i < count($arregloNumeral); $i++) {
                                    $id = $arregloNumeral[$i]->__get('id');
                                    $descripcion = $arregloNumeral[$i]->__get('descripcion');
                                    echo "<option value='$id'>$descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <select class="form-select" id="txtParagrafo" name="txtParagrafo" required>
                                <option selected disabled value="">Paragrafo</option>
                                <?php
                                for ($i = 0; $i < count($arregloParagrafo); $i++) {
                                    $id = $arregloParagrafo[$i]->__get('id');
                                    $descripcion = $arregloParagrafo[$i]->__get('descripcion');
                                    echo "<option value='$id'>$descripcion</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <h5>Selecciona las Representaciones Visuales:</h5>
                        <div class="container mt-3">
                            <?php for ($i = 0; $i < count($arregloRepresenVisual); $i++) {
                                $id = $arregloRepresenVisual[$i]->__get('id');
                                $nombre = $arregloRepresenVisual[$i]->__get('nombre'); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="represen_modal[<?= $id ?>]"
                                        value="<?= $id ?>" id="represen_modal<?= $id ?>_modal">
                                    <label class="form-check-label" for="represen_modal<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <h5>Selecciona los responsables:</h5>
                        <div class="container mt-3">
                            <?php for ($i = 0; $i < count($arregloActor); $i++) {
                                $id = $arregloActor[$i]->__get('id');
                                $nombre = $arregloActor[$i]->__get('nombre'); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="actores_modal[<?= $id ?>]"
                                        value="<?= $id ?>" id="actores_modal<?= $id ?>_modal">
                                    <label class="form-check-label" for="actores_modal<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <h5>Selecciona las Fuentes:</h5>
                        <div class="container mt-3">
                            <?php for ($i = 0; $i < count($arregloFuente); $i++) {
                                $id = $arregloFuente[$i]->__get('id');
                                $nombre = $arregloFuente[$i]->__get('nombre'); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="fuentes_modal[<?= $id ?>]"
                                        value="<?= $id ?>" id="fuentes_modal<?= $id ?>_modal">
                                    <label class="form-check-label" for="fuentes_modal<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <h5>Selecciona las Variables:</h5>
                        <div class="container mt-3">
                            <?php for ($i = 0; $i < count($arregloVariable); $i++) {
                                $id = $arregloVariable[$i]->__get('id');
                                $nombre = $arregloVariable[$i]->__get('nombre'); ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="variables_modal[<?= $id ?>]"
                                        value="<?= $id ?>" id="variables_modal<?= $id ?>_modal">
                                    <label class="form-check-label" for="variables_modal<?= $id ?>_modal">
                                        <?= $nombre ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="action" value="modificar">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="botonCancelar2">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt"
                            value="Modificar">Modificar</button>
                        <button type="submit" class="btn btn-danger" formmethod="post" name="bt" id="confirmDelete"
                            value="Eliminar" hidden>Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Delete Modal HTML -->
    <div class="modal fade" id="deleteIndicador" tabindex="-1" aria-labelledby="deleteIndicador" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="post" action="VistaIndicador.php" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Borrar Indicador</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Está seguro que desea eliminar este indicador?</p>
                        <p class="text-warning"><small>Ésta acción no se puede deshacer.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="txtId" value="" id="txtId">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning" formmethod="post" name="bt" id="confirmDelete"
                            value="Eliminar">Eliminar</button>
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
        if (params.has('id')) {
            const represenvisualcodi = params.get('represenVisual');
            const actorescodi = params.get('actor');
            const fuentescodi = params.get('fuente');
            const variablescodi = params.get('variable');
            const represenvisualdecodi = decodeURIComponent(represenvisualcodi);
            const actoresdecodi = decodeURIComponent(actorescodi);
            const fuentesdecodi = decodeURIComponent(fuentescodi);
            const variablesdecodi = decodeURIComponent(variablescodi);
            // Obtener los valores de los parámetros
            const id = params.get('id');
            const codigo = params.get('codigo');
            const nombre = params.get('nombre');
            const objetivo = params.get('objetivo');
            const alcance = params.get('alcance');
            const formula = params.get('formula');
            const tipoIndicador = params.get('tipoIndicador');
            const unidadMedicion = params.get('unidadMedicion');
            const meta = params.get('meta');
            const sentido = params.get('sentido');
            const frecuencia = params.get('frecuencia');
            const articulo = params.get('articulo');
            const literal = params.get('literal');
            const numeral = params.get('numeral');
            const paragrafo = params.get('paragrafo');
            const represenVisual = JSON.parse(represenvisualdecodi);
            const actores = JSON.parse(actoresdecodi);
            const fuentes = JSON.parse(fuentesdecodi);
            const variables = JSON.parse(variablesdecodi);

            // Abrir el modal editIndicador
            const editUserModal = new bootstrap.Modal(document.getElementById('editIndicador'));

            // Hacer visible el botón confirmDelete
            document.getElementById('confirmDelete').removeAttribute('hidden');
            editUserModal.show();

            // Cargar datos en el modal
            cargarDatos(id, codigo, nombre, objetivo, alcance, formula, tipoIndicador, unidadMedicion, meta, sentido, frecuencia, articulo, literal, numeral, paragrafo, represenVisual, actores, fuentes, variables);
        }
    });

    const openEditModalButtons = document.getElementsByClassName('botonModificar');

    for (let i = 0; i < openEditModalButtons.length; i++) {
        openEditModalButtons[i].addEventListener('click', function () {
            const id = this.getAttribute('data-bs-id');
            const codigo = this.getAttribute('data-bs-codigo');
            const nombre = this.getAttribute('data-bs-nombre');
            const objetivo = this.getAttribute('data-bs-objetivo');
            const alcance = this.getAttribute('data-bs-alcance');
            const formula = this.getAttribute('data-bs-formula');
            const tipoIndicador = this.getAttribute('data-bs-tipoIndicador');
            const unidadMedicion = this.getAttribute('data-bs-unidadMedicion');
            const meta = this.getAttribute('data-bs-meta');
            const sentido = this.getAttribute('data-bs-sentido');
            const frecuencia = this.getAttribute('data-bs-frecuencia');
            const articulo = this.getAttribute('data-bs-articulo');
            const literal = this.getAttribute('data-bs-literal');
            const numeral = this.getAttribute('data-bs-numeral');
            const paragrafo = this.getAttribute('data-bs-paragrafo');
            const represenVisual = this.getAttribute('data-bs-represenvisual').split(',').map(Number); // Convertir a array de números
            const actores = this.getAttribute('data-bs-actores').split(',').map(Number); // Convertir a array de números
            const fuentes = this.getAttribute('data-bs-fuentes').split(',').map(Number); // Convertir a array de números
            const variables = this.getAttribute('data-bs-variables').split(',').map(Number); // Convertir a array de números
            // Abrir el modal editIndicador
            const editUserModal = new bootstrap.Modal(document.getElementById('editIndicador'));

            // Hacer visible el botón confirmDelete
            document.getElementById('confirmDelete').setAttribute('hidden', 'true');
            editUserModal.show();

            // Cargar datos en el modal
            cargarDatos(id, codigo, nombre, objetivo, alcance, formula, tipoIndicador, unidadMedicion, meta, sentido, frecuencia, articulo, literal, numeral, paragrafo, represenVisual, actores, fuentes, variables);
        });
    }

    const CancelarEditButton = document.getElementById('botonCancelar2');

    if (CancelarEditButton) {
        CancelarEditButton.addEventListener('click', () => {
            const editUserModal = new bootstrap.Modal(document.getElementById('editIndicador'));
            editUserModal.hide();

            // Eliminar la clase .modal-backdrop
            const modalBackdrop = document.querySelector('.modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.remove();
            }
        });
    }

    // Función para cargar los datos en el modal
    function cargarDatos(id, codigo, nombre, objetivo, alcance, formula, tipoIndicador, unidadMedicion, meta, sentido, frecuencia, articulo, literal, numeral, paragrafo, represenVisual, actores, fuentes, variables) {
        const modalTitle = editIndicador.querySelector('.modal-title');
        const idInput = editIndicador.querySelector('#txtId');
        const codigoInput = editIndicador.querySelector('#txtCodigo');
        const nombreInput = editIndicador.querySelector('#txtNombre');
        const objetivoInput = editIndicador.querySelector('#txtObjetivo');
        const alcanceInput = editIndicador.querySelector('#txtAlcance');
        const formulaInput = editIndicador.querySelector('#txtFormula');
        const tipoIndicadorInput = editIndicador.querySelector('#txtTipoIndicador');
        const unidadMedicionInput = editIndicador.querySelector('#txtUnidadMedicion');
        const metaInput = editIndicador.querySelector('#txtMeta');
        const sentidoInput = editIndicador.querySelector('#txtSentido');
        const frecuenciaInput = editIndicador.querySelector('#txtFrecuencia');
        const articuloInput = editIndicador.querySelector('#txtArticulo');
        const literalInput = editIndicador.querySelector('#txtLiteral');
        const numeralInput = editIndicador.querySelector('#txtNumeral');
        const paragrafoInput = editIndicador.querySelector('#txtParagrafo');

        modalTitle.textContent = `Modificar Indicador ${id}`;
        idInput.value = id;
        codigoInput.value = codigo;
        nombreInput.value = nombre;
        objetivoInput.value = objetivo;
        alcanceInput.value = alcance;
        formulaInput.value = formula;
        tipoIndicadorInput.value = tipoIndicador;
        unidadMedicionInput.value = unidadMedicion;
        metaInput.value = meta;
        sentidoInput.value = sentido;
        frecuenciaInput.value = frecuencia;
        articuloInput.value = articulo;
        literalInput.value = literal;
        numeralInput.value = numeral;
        paragrafoInput.value = paragrafo;

        // Resetear todos los checkboxes a falso
        document.querySelectorAll('.form-check-input').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Activar los checkboxes correspondientes
        represenVisual.forEach(id => {
            const checkbox = document.getElementById(`represen_modal${id}_modal`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        actores.forEach(id => {
            const checkbox = document.getElementById(`actores_modal${id}_modal`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        fuentes.forEach(id => {
            const checkbox = document.getElementById(`fuentes_modal${id}_modal`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        variables.forEach(id => {
            const checkbox = document.getElementById(`variables_modal${id}_modal`);
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }

    const deleteUser = document.getElementById('deleteIndicador')
    if (deleteUser) {
        deleteUser.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const id = button.getAttribute('data-bs-id')
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = deleteUser.querySelector('.modal-title')
            const idInput = deleteUser.querySelector('#txtId')

            modalTitle.textContent = `Eliminar usuario ${id}`
            idInput.value = id
        })
    }
</script>

<?php include 'footer.html'; ?>
<?php
ob_end_flush();
?>