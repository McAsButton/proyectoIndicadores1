<?php
ob_start();
?>
<?php
include_once '../control/configBd.php';
include_once '../control/ControlEntidad.php';
include_once '../control/ControlConexionPdo.php'; //cspell:disable-line
include_once '../modelo/Entidad.php';
include_once 'notificacion.html'; //cspell:disable-line

session_start();
if ($_SESSION['email'] == null)
    header('Location: index.php');
$permisoParaEntrar = false;
if (isset($_SESSION['admin']) || isset($_SESSION['verificador']) || isset($_SESSION['validador']) || isset($_SESSION['administrativo']))
    $permisoParaEntrar = true;
if (!$permisoParaEntrar)
    header('Location: index.php');

// Establecer la zona horaria a la local del servidor
date_default_timezone_set('America/Bogota');

$objControlIndicador = new ControlEntidad('indicador');

$boton = $_POST['bt'] ?? ''; // Captura el valor del botón
$consulta = $_POST['listConsulta'] ?? ''; // Captura el valor del campo de texto

if ($boton == 'Consultar' && !empty($consulta)) {
    switch ($consulta) {
        case 1:
            header('Location: vistaConsultas.php?Consulta=1');
            break;
        case 2:
            header('Location: vistaConsultas.php?Consulta=2');
            break;
        case 3:
            header('Location: vistaConsultas.php?Consulta=3');
            break;
        case 4:
            header('Location: vistaConsultas.php?Consulta=4');
            break;
        case 5:
            header('Location: vistaConsultas.php?Consulta=5');
            break;
        case 6:
            header('Location: vistaConsultas.php?Consulta=6');
            break;
    }
}
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    ob_end_clean(); // Limpiar el búfer de salida
    // Obtener las variables globales
    $host = $GLOBALS['serv'];
    $username = $GLOBALS['usua'];
    $password = $GLOBALS['pass'];
    $dbname = $GLOBALS['bdat'];

    // Conectar a la base de datos
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password); //nueva instancia de PDO para conectarse a la base de datos
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establecer el modo de error de PDO a excepciones

        // Obtener todas las tablas de la base de datos
        $tablesQuery = $pdo->query("SHOW TABLES"); //consulta para obtener todas las tablas de la base de datos
        $tables = $tablesQuery->fetchAll(PDO::FETCH_COLUMN); //obtener todas las tablas de la base de datos en un array

        // Definir el nombre del archivo CSV
        $filename = 'backup_bdindicadores1_' . date('Y-m-d_H-i-s') . '.csv'; 

        // Configurar los encabezados HTTP para la descarga del archivo CSV
        header('Content-Type: text/csv'); //tipo de contenido
        header('Content-Disposition: attachment;filename=' . $filename); //disposición del contenido

        // Abrir la salida estándar para escribir el CSV
        $output = fopen('php://output', 'w');

        if ($tables) { //si hay tablas en la base de datos
            foreach ($tables as $table) { //recorrer todas las tablas
                // Obtener los datos de la tabla actual
                $dataQuery = $pdo->query("SELECT * FROM $table"); //consulta para obtener todos los datos de la tabla actual
                $data = $dataQuery->fetchAll(PDO::FETCH_ASSOC); //obtener todos los datos de la tabla actual en un array

                if ($data) { //si hay datos en la tabla
                    // Escribir el nombre de la tabla como título
                    fputcsv($output, [$table]);

                    // Escribir los encabezados de las columnas
                    fputcsv($output, array_keys($data[0]));

                    // Escribir los datos de cada fila
                    foreach ($data as $row) {
                        fputcsv($output, $row);
                    }

                    // Añadir una línea en blanco entre tablas
                    fputcsv($output, []);
                } else {
                    echo "No hay datos en la tabla $table.<br>";
                }
            }
        } else {
            echo "No se encontraron tablas en la base de datos.<br>";
        }

        // Cerrar el archivo de salida para finalizar la escritura del CSV y enviarlo al navegador para su descarga 
        fclose($output);
        exit(); 
    } catch (PDOException $e) {
        ob_end_clean(); // Limpiar el búfer de salida si hay un error
        echo "Error al conectar a la base de datos: " . $e->getMessage();
    }
    ob_end_flush(); // Enviar el contenido del búfer de salida
}
if ($boton == 'Exportar') {
    header('Location: vistaConsultas.php?export=csv');
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
                                <h2><b>Administrar</b> Consultas</h2>
                            </div>
                            <div class="col-sm">
                                <form class="d-flex" method="post" action="VistaConsultas.php">
                                    <button class="btn btn-outline-success" type="submit" formmethod="post" name="bt" value="Exportar"><i class="bi bi-filetype-csv"> Exportar BD</i></button>
                                </form>
                            </div>
                            <div class="col-sm">
                                <form class="d-flex" method="post" action="VistaConsultas.php">
                                    <!-- Listado con las consultas -->
                                    <select class="form-select" name="listConsulta" id="consulta">
                                        <option value="0">Seleccione una consulta</option>
                                        <option value="1">Consultar tabla indicadores con nombre tipo indicador, nombre del sentido y descripcion de la unidad de medicion</option>
                                        <option value="2">Consultar tabla indicadores con nombre representacion visual</option>
                                        <option value="3">Consultar tabla indicadores con nombre actor y tipo actor</option>
                                        <option value="4">Consultar tabla indicadores con nombre fuente</option>
                                        <option value="5">Consultar tabla indicadores con nombre variable, dato variable y fecha dato</option>
                                        <option value="6">Consultar tabla indicadores con resultado, fecha resultado</option>
                                    </select>
                                    <button class="btn btn-outline-success" type="submit" formmethod="post" name="bt" value="Consultar"><i class="bi bi-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover table-responsive-sm" id="Consulta1" hidden>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Objetivo</th>
                                <th>Alcance</th>
                                <th>Formula</th>
                                <th>FkIdTipoIndicador</th>
                                <th>Nombre Tipo Indicador</th>
                                <th>FkIdUnidadMedicion</th>
                                <th>Descripcion Unidad Medicion</th>
                                <th>Meta</th>
                                <th>FkIdSentido</th>
                                <th>Nombre Sentido</th>
                                <th>FkIdFrecuencia</th>
                                <th>FkIdArticulo</th>
                                <th>FkIdLiteral</th>
                                <th>FkIdNumeral</th>
                                <th>FkIdParagrafo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            $nombre_tipoindicador = '';
                            $descripcion_unidadmedicion = '';
                            $nombre_sentido = '';
                            $sql = "SELECT
                                i.id,
                                i.codigo,
                                i.nombre,
                                i.objetivo,
                                i.alcance,
                                i.formula,
                                i.fkidtipoindicador,
                                t.nombre AS nombre_tipoindicador,
                                i.fkidunidadmedicion,
                                u.descripcion AS descripcion_unidadmedicion,
                                i.meta,
                                i.fkidsentido,
                                s.nombre AS nombre_sentido,
                                i.fkidfrecuencia,
                                i.fkidarticulo,
                                i.fkidliteral,
                                i.fkidnumeral,
                                i.fkidparagrafo
                            FROM 
                                indicador i
                            JOIN 
                                tipoindicador t ON i.fkidtipoindicador = t.id
                            JOIN 
                                unidadmedicion u ON i.fkidunidadmedicion = u.id
                            JOIN 
                                sentido s ON i.fkidsentido = s.id;";
                            $parametros = [];
                            $arregloIndicadores = $objControlIndicador->consultar($sql, $parametros);

                            $registros_por_pagina = 5;
                            $total_registros = count($arregloIndicadores);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $entidad = $arregloIndicadores[$i];
                                $num_registro = $i + 1;

                                $propiedades = $entidad->obtenerPropiedades();
                                $id = isset($propiedades['id']) ? $propiedades['id'] : '';
                                $codigo = isset($propiedades['codigo']) ? $propiedades['codigo'] : '';
                                $nombre = isset($propiedades['nombre']) ? $propiedades['nombre'] : '';
                                $objetivo = isset($propiedades['objetivo']) ? $propiedades['objetivo'] : '';
                                $alcance = isset($propiedades['alcance']) ? $propiedades['alcance'] : '';
                                $formula = isset($propiedades['formula']) ? $propiedades['formula'] : '';
                                $fkidtipoindicador = isset($propiedades['fkidtipoindicador']) ? $propiedades['fkidtipoindicador'] : '';
                                $nombre_tipoindicador = isset($propiedades['nombre_tipoindicador']) ? $propiedades['nombre_tipoindicador'] : '';
                                $fkidunidadmedicion = isset($propiedades['fkidunidadmedicion']) ? $propiedades['fkidunidadmedicion'] : '';
                                $descripcion_unidadmedicion = isset($propiedades['descripcion_unidadmedicion']) ? $propiedades['descripcion_unidadmedicion'] : '';
                                $meta = isset($propiedades['meta']) ? $propiedades['meta'] : '';
                                $fkidsentido = isset($propiedades['fkidsentido']) ? $propiedades['fkidsentido'] : '';
                                $nombre_sentido = isset($propiedades['nombre_sentido']) ? $propiedades['nombre_sentido'] : '';
                                $fkidfrecuencia = isset($propiedades['fkidfrecuencia']) ? $propiedades['fkidfrecuencia'] : '';
                                $fkidarticulo = isset($propiedades['fkidarticulo']) ? $propiedades['fkidarticulo'] : '';
                                $fkidliteral = isset($propiedades['fkidliteral']) ? $propiedades['fkidliteral'] : '';
                                $fkidnumeral = isset($propiedades['fkidnumeral']) ? $propiedades['fkidnumeral'] : '';
                                $fkidparagrafo = isset($propiedades['fkidparagrafo']) ? $propiedades['fkidparagrafo'] : '';
                            ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $id ?></td>
                                    <td><?= $codigo ?></td>
                                    <td><?= $nombre ?></td>
                                    <td><?= $objetivo ?></td>
                                    <td><?= $alcance ?></td>
                                    <td><?= $formula ?></td>
                                    <td><?= $fkidtipoindicador ?></td>
                                    <td><?= $nombre_tipoindicador ?></td>
                                    <td><?= $fkidunidadmedicion ?></td>
                                    <td><?= $descripcion_unidadmedicion ?></td>
                                    <td><?= $meta ?></td>
                                    <td><?= $fkidsentido ?></td>
                                    <td><?= $nombre_sentido ?></td>
                                    <td><?= $fkidfrecuencia ?></td>
                                    <td><?= $fkidarticulo ?></td>
                                    <td><?= $fkidliteral ?></td>
                                    <td><?= $fkidnumeral ?></td>
                                    <td><?= $fkidparagrafo ?></td>
                                </tr>
                            <?php
                            }
                            $registros_mostrados = min($registros_por_pagina, $total_registros - $inicio);
                            ?>
                        </tbody>
                    </table>
                    <!-- Mostrar enlaces de paginación -->
                    <div class="clearfix" id="PagCons1" hidden>
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de
                            <b><?= $total_registros ?></b> indicadores
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=1&pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaConsultas.php?Consulta=1&pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaConsultas.php?Consulta=1&pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=1&pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                            ?>
                        </ul>
                    </div>
                    <table class="table table-striped table-hover table-responsive-sm" id="Consulta2" hidden>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Codigo</th>
                                <th>Objetivo</th>
                                <th>Formula</th>
                                <th>Meta</th>
                                <th>Nombre Representacion Visual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            $sql = "SELECT
                                i.id,
                                i.nombre,
                                i.codigo,
                                i.objetivo,
                                i.formula,
                                i.meta,
                                rv.nombre AS nombre_represen_visual
                            FROM
                                indicador i
                            JOIN
                                represenvisualporindicador rvi ON i.id = rvi.fkidindicador
                            JOIN
                                represenvisual rv ON rvi.fkidrepresenvisual = rv.id;";
                            $parametros = [];
                            $arregloIndicadores = $objControlIndicador->consultar($sql, $parametros);

                            $registros_por_pagina = 5;
                            $total_registros = count($arregloIndicadores);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $entidad = $arregloIndicadores[$i];
                                $num_registro = $i + 1;

                                $propiedades = $entidad->obtenerPropiedades();
                                $id = $propiedades['id'];
                                $nombre = $propiedades['nombre'];
                                $codigo = $propiedades['codigo'];
                                $objetivo = $propiedades['objetivo'];
                                $formula = $propiedades['formula'];
                                $meta = $propiedades['meta'];
                                $nombre_representacion_visual = isset($propiedades['nombre_represen_visual']) ? $propiedades['nombre_represen_visual'] : '';
                            ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $id ?></td>
                                    <td><?= $nombre ?></td>
                                    <td><?= $codigo ?></td>
                                    <td><?= $objetivo ?></td>
                                    <td><?= $formula ?></td>
                                    <td><?= $meta ?></td>
                                    <td><?= $nombre_representacion_visual ?></td>
                                </tr>
                            <?php
                            }
                            $registros_mostrados = min($registros_por_pagina, $total_registros - $inicio);
                            ?>
                        </tbody>
                    </table>
                    <!-- Mostrar enlaces de paginación -->
                    <div class="clearfix" id="PagCons2" hidden>
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de
                            <b><?= $total_registros ?></b> indicadores
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=2&pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaConsultas.php?Consulta=2&pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaConsultas.php?Consulta=2&pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=2&pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                            ?>
                        </ul>
                    </div>
                    <table class="table table-striped table-hover table-responsive-sm" id="Consulta3" hidden>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Nombre Codigo</th>
                                <th>Objetivo</th>
                                <th>Formula</th>
                                <th>Meta</th>
                                <th>Nombre Actor</th>
                                <th>Tipo Actor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            $sql = "SELECT 
                                i.id, 
                                i.nombre AS nombre_codigo, 
                                i.objetivo, 
                                i.formula, 
                                i.meta, 
                                a.nombre AS nombre_actor, 
                                ta.nombre AS tipo_actor
                            FROM 
                                indicador i
                            LEFT JOIN 
                                responsablesporindicador ri ON i.id = ri.fkidindicador
                            LEFT JOIN 
                                actor a ON ri.fkidresponsable = a.id
                            LEFT JOIN 
                                tipoactor ta ON a.fkidtipoactor = ta.id;";
                            $parametros = [];
                            $arregloIndicadores = $objControlIndicador->consultar($sql, $parametros);

                            $registros_por_pagina = 5;
                            $total_registros = count($arregloIndicadores);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $entidad = $arregloIndicadores[$i];
                                $num_registro = $i + 1;

                                $propiedades = $entidad->obtenerPropiedades();
                                $id = $propiedades['id'];
                                $nombre = isset($propiedades['nombre_codigo']) ? $propiedades['nombre_codigo'] : '';
                                $objetivo = $propiedades['objetivo'];
                                $formula = $propiedades['formula'];
                                $meta = $propiedades['meta'];
                                $nombre_actor = $propiedades['nombre_actor'];
                                $tipo_actor = $propiedades['tipo_actor'];
                            ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $id ?></td>
                                    <td><?= $nombre ?></td>
                                    <td><?= $objetivo ?></td>
                                    <td><?= $formula ?></td>
                                    <td><?= $meta ?></td>
                                    <td><?= $nombre_actor ?></td>
                                    <td><?= $tipo_actor ?></td>
                                </tr>
                            <?php
                            }
                            $registros_mostrados = min($registros_por_pagina, $total_registros - $inicio);
                            ?>
                    </table>
                    <!-- Mostrar enlaces de paginación -->
                    <div class="clearfix" id="PagCons3" hidden>
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de
                            <b><?= $total_registros ?></b> indicadores
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=3&pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaConsultas.php?Consulta=3&pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaConsultas.php?Consulta=3&pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=3&pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                            ?>
                        </ul>
                    </div>
                    <table class="table table-striped table-hover table-responsive-sm" id="Consulta4" hidden>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Nombre Codigo</th>
                                <th>Objetivo</th>
                                <th>Formula</th>
                                <th>Meta</th>
                                <th>Nombre Fuente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            $sql = "SELECT 
                                i.id, 
                                i.nombre AS nombre_codigo, 
                                i.objetivo, 
                                i.formula, 
                                i.meta, 
                                f.nombre AS fuente_nombre
                            FROM 
                                indicador i
                            JOIN 
                                fuentesporindicador fi ON i.id = fi.fkidindicador
                            JOIN 
                                fuente f ON fi.fkidfuente = f.id;";
                            $parametros = [];
                            $arregloIndicadores = $objControlIndicador->consultar($sql, $parametros);

                            $registros_por_pagina = 5;
                            $total_registros = count($arregloIndicadores);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $entidad = $arregloIndicadores[$i];
                                $num_registro = $i + 1;

                                $propiedades = $entidad->obtenerPropiedades();
                                $id = $propiedades['id'];
                                $nombre = isset($propiedades['nombre_codigo']) ? $propiedades['nombre_codigo'] : '';
                                $objetivo = $propiedades['objetivo'];
                                $formula = $propiedades['formula'];
                                $meta = $propiedades['meta'];
                                $nombre_fuente = isset($propiedades['fuente_nombre']) ? $propiedades['fuente_nombre'] : '';
                            ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $id ?></td>
                                    <td><?= $nombre ?></td>
                                    <td><?= $objetivo ?></td>
                                    <td><?= $formula ?></td>
                                    <td><?= $meta ?></td>
                                    <td><?= $nombre_fuente ?></td>
                                </tr>
                            <?php
                            }
                            $registros_mostrados = min($registros_por_pagina, $total_registros - $inicio);
                            ?>
                        </tbody>
                    </table>
                    <!-- Mostrar enlaces de paginación -->
                    <div class="clearfix" id="PagCons4" hidden>
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de
                            <b><?= $total_registros ?></b> indicadores
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=4&pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaConsultas.php?Consulta=4&pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaConsultas.php?Consulta=4&pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=4&pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                            ?>
                        </ul>
                    </div>
                    <table class="table table-striped table-hover table-responsive-sm" id="Consulta5" hidden>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Nombre Codigo</th>
                                <th>Objetivo</th>
                                <th>Formula</th>
                                <th>Meta</th>
                                <th>Variable</th>
                                <th>Dato Variable</th>
                                <th>Fecha Dato</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            $sql = "SELECT 
                                i.id, 
                                i.nombre AS nombre_codigo,  
                                i.objetivo, 
                                i.formula, 
                                i.meta, 
                                v.nombre AS nombre_variable,
                                vi.dato,
                                vi.fechadato
                            FROM 
                                indicador i
                            JOIN 
                                variablesporindicador vi ON i.id = vi.fkidindicador
                            JOIN 
                                variable v ON vi.fkidvariable = v.id;";
                            $parametros = [];
                            $arregloIndicadores = $objControlIndicador->consultar($sql, $parametros);

                            $registros_por_pagina = 5;
                            $total_registros = count($arregloIndicadores);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $entidad = $arregloIndicadores[$i];
                                $num_registro = $i + 1;

                                $propiedades = $entidad->obtenerPropiedades();
                                $id = $propiedades['id'];
                                $nombre = isset($propiedades['nombre_codigo']) ? $propiedades['nombre_codigo'] : '';
                                $objetivo = $propiedades['objetivo'];
                                $formula = $propiedades['formula'];
                                $meta = $propiedades['meta'];
                                $variable = $propiedades['nombre_variable'];
                                $dato_variable = $propiedades['dato'];
                                $fecha_dato = $propiedades['fechadato'];
                            ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $id ?></td>
                                    <td><?= $nombre ?></td>
                                    <td><?= $objetivo ?></td>
                                    <td><?= $formula ?></td>
                                    <td><?= $meta ?></td>
                                    <td><?= $variable ?></td>
                                    <td><?= $dato_variable ?></td>
                                    <td><?= $fecha_dato ?></td>
                                </tr>
                            <?php
                            }
                            $registros_mostrados = min($registros_por_pagina, $total_registros - $inicio);
                            ?>
                        </tbody>
                    </table>
                    <!-- Mostrar enlaces de paginación -->
                    <div class="clearfix" id="PagCons5" hidden>
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de
                            <b><?= $total_registros ?></b> indicadores
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=5&pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaConsultas.php?Consulta=5&pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaConsultas.php?Consulta=5&pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=5&pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                            ?>
                        </ul>
                    </div>
                    <table class="table table-striped table-hover table-responsive-sm" id="Consulta6" hidden>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Objetivo</th>
                                <th>Alcance</th>
                                <th>Formula</th>
                                <th>FkIdTipoIndicador</th>
                                <th>FkUnidadMedicion</th>
                                <th>Meta</th>
                                <th>FkIdSentido</th>
                                <th>FkIdFrecuencia</th>
                                <th>FkIdArticulo</th>
                                <th>FkIdLiteral</th>
                                <th>FkIdNumeral</th>
                                <th>FkIdParagrafo</th>
                                <th>Id Resultado</th>
                                <th>Resultado</th>
                                <th>Fecha Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            $sql = "SELECT 
                                i.*, 
                                ri.id AS id_resultado, 
                                ri.resultado, 
                                ri.fechacalculo
                            FROM 
                                indicador i
                            LEFT JOIN 
                                resultadoindicador ri ON i.id = ri.fkidindicador;";
                            $parametros = [];
                            $arregloIndicadores = $objControlIndicador->consultar($sql, $parametros);

                            $registros_por_pagina = 5;
                            $total_registros = count($arregloIndicadores);
                            $total_paginas = ceil($total_registros / $registros_por_pagina);
                            $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
                            $inicio = ($pagina_actual - 1) * $registros_por_pagina;
                            $fin = $inicio + $registros_por_pagina;

                            for ($i = $inicio; $i < $fin && $i < $total_registros; $i++) {
                                $entidad = $arregloIndicadores[$i];
                                $num_registro = $i + 1;

                                $propiedades = $entidad->obtenerPropiedades();
                                $id = $propiedades['id'];
                                $codigo = $propiedades['codigo'];
                                $nombre = $propiedades['nombre'];
                                $objetivo = $propiedades['objetivo'];
                                $alcance = $propiedades['alcance'];
                                $formula = $propiedades['formula'];
                                $fkidtipoindicador = $propiedades['fkidtipoindicador'];
                                $fkidunidadmedicion = $propiedades['fkidunidadmedicion'];
                                $meta = $propiedades['meta'];
                                $fkidsentido = $propiedades['fkidsentido'];
                                $fkidfrecuencia = $propiedades['fkidfrecuencia'];
                                $fkidarticulo = $propiedades['fkidarticulo'];
                                $fkidliteral = $propiedades['fkidliteral'];
                                $fkidnumeral = $propiedades['fkidnumeral'];
                                $fkidparagrafo = $propiedades['fkidparagrafo'];
                                $id_resultado = $propiedades['id_resultado'];
                                $resultado = $propiedades['resultado'];
                                $fecha_resultado = isset($propiedades['fechacalculo']) ? $propiedades['fechacalculo'] : '';
                            ?>
                                <tr>
                                    <td><?= $num_registro ?></td>
                                    <td><?= $id ?></td>
                                    <td><?= $codigo ?></td>
                                    <td><?= $nombre ?></td>
                                    <td><?= $objetivo ?></td>
                                    <td><?= $alcance ?></td>
                                    <td><?= $formula ?></td>
                                    <td><?= $fkidtipoindicador ?></td>
                                    <td><?= $fkidunidadmedicion ?></td>
                                    <td><?= $meta ?></td>
                                    <td><?= $fkidsentido ?></td>
                                    <td><?= $fkidfrecuencia ?></td>
                                    <td><?= $fkidarticulo ?></td>
                                    <td><?= $fkidliteral ?></td>
                                    <td><?= $fkidnumeral ?></td>
                                    <td><?= $fkidparagrafo ?></td>
                                    <td><?= $id_resultado ?></td>
                                    <td><?= $resultado ?></td>
                                    <td><?= $fecha_resultado ?></td>
                                </tr>
                            <?php
                            }
                            $registros_mostrados = min($registros_por_pagina, $total_registros - $inicio);
                            ?>
                        </tbody>
                    </table>
                    <!-- Mostrar enlaces de paginación -->
                    <div class="clearfix" id="PagCons6" hidden>
                        <div class="hint-text">Mostrando <b><?= $registros_mostrados ?></b> de
                            <b><?= $total_registros ?></b> indicadores
                        </div>
                        <ul class="pagination">
                            <?php
                            // Botón "Anterior"
                            echo "<li class='page-item " . ($pagina_actual == 1 ? 'disabled' : '') . "' style='" . ($pagina_actual == 1 ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=6&pagina=" . ($pagina_actual - 1) . "' class='page-link'>Anterior</a></li>";

                            // Números de página
                            for ($i = 1; $i <= $total_paginas; $i++) {
                                if ($pagina_actual == $i) {
                                    echo "<li class='page-item active'><a href='vistaConsultas.php?Consulta=6&pagina=$i' class='page-link'>$i</a></li>";
                                } else {
                                    echo "<li class='page-item'><a href='vistaConsultas.php?Consulta=6&pagina=$i' class='page-link'>$i</a></li>";
                                }
                            }
                            // Botón "Siguiente"
                            echo "<li class='page-item " . ($pagina_actual == $total_paginas ? 'disabled' : '') . "' style='" . ($pagina_actual == $total_paginas ? 'display: none;' : '') . "'><a href='vistaConsultas.php?Consulta=6&pagina=" . ($pagina_actual + 1) . "' class='page-link'>Siguiente</a></li>";
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<main id="main">

</main><!-- End #main -->
<script>
    window.addEventListener("DOMContentLoaded", () => {
        // Crear un objeto URLSearchParams con la parte de búsqueda de la URL
        const params = new URLSearchParams(window.location.search);

        // Obtener el valor del parámetro 'Consulta'
        const consulta = params.get('Consulta');

        // Si el valor del parámetro 'Consulta' es '1', mostrar la tabla con id 'Consulta1'
        if (consulta === '1') {
            document.getElementById('Consulta1').removeAttribute('hidden');
            document.getElementById('PagCons1').removeAttribute('hidden');
            document.getElementById('consulta2').setAttribute('hidden', 'true');
            document.getElementById('PagCons2').setAttribute('hidden', 'true');
            document.getElementById('consulta3').setAttribute('hidden', 'true');
            document.getElementById('PagCons3').setAttribute('hidden', 'true');
            document.getElementById('consulta4').setAttribute('hidden', 'true');
            document.getElementById('PagCons4').setAttribute('hidden', 'true');
            document.getElementById('consulta5').setAttribute('hidden', 'true');
            document.getElementById('PagCons5').setAttribute('hidden', 'true');
            document.getElementById('consulta6').setAttribute('hidden', 'true');
            document.getElementById('PagCons6').setAttribute('hidden', 'true');
        }
        if (consulta === '2') {
            document.getElementById('Consulta2').removeAttribute('hidden');
            document.getElementById('PagCons2').removeAttribute('hidden');
            document.getElementById('consulta1').setAttribute('hidden', 'true');
            document.getElementById('PagCons1').setAttribute('hidden', 'true');
            document.getElementById('consulta3').setAttribute('hidden', 'true');
            document.getElementById('PagCons3').setAttribute('hidden', 'true');
            document.getElementById('consulta4').setAttribute('hidden', 'true');
            document.getElementById('PagCons4').setAttribute('hidden', 'true');
            document.getElementById('consulta5').setAttribute('hidden', 'true');
            document.getElementById('PagCons5').setAttribute('hidden', 'true');
            document.getElementById('consulta6').setAttribute('hidden', 'true');
            document.getElementById('PagCons6').setAttribute('hidden', 'true');

        }
        if (consulta === '3') {
            document.getElementById('Consulta3').removeAttribute('hidden');
            document.getElementById('PagCons3').removeAttribute('hidden');
            document.getElementById('consulta1').setAttribute('hidden', 'true');
            document.getElementById('PagCons1').setAttribute('hidden', 'true');
            document.getElementById('consulta2').setAttribute('hidden', 'true');
            document.getElementById('PagCons2').setAttribute('hidden', 'true');
            document.getElementById('consulta4').setAttribute('hidden', 'true');
            document.getElementById('PagCons4').setAttribute('hidden', 'true');
            document.getElementById('consulta5').setAttribute('hidden', 'true');
            document.getElementById('PagCons5').setAttribute('hidden', 'true');
            document.getElementById('consulta6').setAttribute('hidden', 'true');
            document.getElementById('PagCons6').setAttribute('hidden', 'true');
        }
        if (consulta === '4') {
            document.getElementById('Consulta4').removeAttribute('hidden');
            document.getElementById('PagCons4').removeAttribute('hidden');
            document.getElementById('consulta1').setAttribute('hidden', 'true');
            document.getElementById('PagCons1').setAttribute('hidden', 'true');
            document.getElementById('consulta2').setAttribute('hidden', 'true');
            document.getElementById('PagCons2').setAttribute('hidden', 'true');
            document.getElementById('consulta3').setAttribute('hidden', 'true');
            document.getElementById('PagCons3').setAttribute('hidden', 'true');
            document.getElementById('consulta5').setAttribute('hidden', 'true');
            document.getElementById('PagCons5').setAttribute('hidden', 'true');
            document.getElementById('consulta6').setAttribute('hidden', 'true');
            document.getElementById('PagCons6').setAttribute('hidden', 'true');
        }
        if (consulta === '5') {
            document.getElementById('Consulta5').removeAttribute('hidden');
            document.getElementById('PagCons5').removeAttribute('hidden');
            document.getElementById('consulta1').setAttribute('hidden', 'true');
            document.getElementById('PagCons1').setAttribute('hidden', 'true');
            document.getElementById('consulta2').setAttribute('hidden', 'true');
            document.getElementById('PagCons2').setAttribute('hidden', 'true');
            document.getElementById('consulta3').setAttribute('hidden', 'true');
            document.getElementById('PagCons3').setAttribute('hidden', 'true');
            document.getElementById('consulta4').setAttribute('hidden', 'true');
            document.getElementById('PagCons4').setAttribute('hidden', 'true');
            document.getElementById('consulta6').setAttribute('hidden', 'true');
            document.getElementById('PagCons6').setAttribute('hidden', 'true');
        }
        if (consulta === '6') {
            document.getElementById('Consulta6').removeAttribute('hidden');
            document.getElementById('PagCons6').removeAttribute('hidden');
            document.getElementById('consulta1').setAttribute('hidden', 'true');
            document.getElementById('PagCons1').setAttribute('hidden', 'true');
            document.getElementById('consulta2').setAttribute('hidden', 'true');
            document.getElementById('PagCons2').setAttribute('hidden', 'true');
            document.getElementById('consulta3').setAttribute('hidden', 'true');
            document.getElementById('PagCons3').setAttribute('hidden', 'true');
            document.getElementById('consulta4').setAttribute('hidden', 'true');
            document.getElementById('PagCons4').setAttribute('hidden', 'true');
            document.getElementById('consulta5').setAttribute('hidden', 'true');
            document.getElementById('PagCons5').setAttribute('hidden', 'true');
        }
    });
</script>

<?php include 'footer.html'; ?>
<?php
ob_end_flush();
?>