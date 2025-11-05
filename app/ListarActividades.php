<?php
// Configuración de rutas
$dir = __DIR__;
$dirHref = '/EjerciciosDWEB/dw_01Eval_4VGym';

// Gestión de sesión
require_once $dir . '/../utils/GestorSesion.php';
GestorSesion::iniciarSesionSiNoEstaIniciada();
$_SESSION['last_page'] = 'ListarActividades.php'; // Guardamos la última página visitada [cite: 82]

// Incluimos el DAO
require_once $dir . '/../persistence/DAO/ActividadesDAO.php';

// Creamos la instancia del DAO
$actividadDAO = new ActividadesDAO();

// --- BORRAR ACTIVIDAD ---
// Comprobamos si nos llega una petición GET para borrar
if (isset($_GET['delete_id'])) {
    $id_a_borrar = $_GET['delete_id'];

    // Verificar que el ID existe antes de borrar
    $actividad_existe = $actividadDAO->selectById($id_a_borrar);

    if ($actividad_existe) {
        // Si existe, se elimina
        $actividadDAO->delete($id_a_borrar);
    }
    // Si no existe, no hacemos nada

    // Redirigimos a ListarActividades.php para limpiar la URL y así refrescar el listado
    header("Location: " . $dirHref . "/app/ListarActividades.php");
    exit;
}

// --- FILTRAR POR FECHA ---
$fecha_filtro = null;
// Validamos que la fecha esté presente y no esté vacía
if (isset($_GET['activityDate']) && !empty($_GET['activityDate'])) {
    // (Idealmente se validaría el formato YYYY-MM-DD)
    $fecha_filtro = $_GET['activityDate'];
    // Buscamos en el servidor las actividades de esa fecha
    $actividades = $actividadDAO->selectByDate($fecha_filtro);
} else {
    // --- MOSTRAR TODO ---
    $actividades = $actividadDAO->selectAll();
}


// --- VISTA ---
// Incluimos la cabecera
require_once $dir . '/../templates/header.php';
?>

<!-- Vista del listado de actividades -->
<div class="alert alert-warning">
    <div class="row">
        <div class="col-md-5">
            <img class="img-fluid img-rounded" src="<?php echo $dirHref . '/assets/img/main-logo.png'; ?>" alt="">
        </div>
        <div class="col-md-7">
            <h1>4VGym, GYM de 4V</h1>
            <p>Ponte en forma y ganaras vida</p>
            <hr />
            <form action="<?php echo $dirHref . '/app/ListarActividades.php'; ?>" method="get" class="row g-2 align-items-center">
                <div class="col-auto">
                    <input name="activityDate" id="activityDate" class="form-control" type="date" value="<?php echo htmlspecialchars($fecha_filtro ?? ''); ?>" />
                </div>
                <div class="col-auto">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">

    <?php
    // Comprobar si hay resultados
    if (empty($actividades)) :
    ?>
        <div class="col-12">
            <div class="alert alert-info" role="alert">
                No hay actividades en la fecha seleccionada.
            </div>
        </div>
        <?php
    // Si hay actividades, las mostramos
    else :
        foreach ($actividades as $actividad) :
            // Lógica para la imagen
            $ruta_imagen = $dirHref . '/assets/img/main-logo.png'; // Imagen por defecto
            if ($actividad['type'] === 'bodypump') {
                $ruta_imagen = $dirHref . '/assets/img/bodypump.png';
            } elseif ($actividad['type'] === 'spinning') {
                $ruta_imagen = $dirHref . '/assets/img/spinning2.png';
            } elseif ($actividad['type'] === 'pilates') {
                $ruta_imagen = $dirHref . '/assets/img/pilates.png';
            }
        ?>
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img class="card-img-top w-50 p-3 img-fluid mx-auto" src='<?php echo $ruta_imagen; ?>' alt="<?php echo $actividad['type']; ?>">
                    <div class="card-body">
                        <h2 class="card-title display-4"><?php echo htmlspecialchars($actividad['place']); ?></h2>
                        <p class="card-text lead"><?php echo date('d M Y H:i', strtotime($actividad['date'])); ?>h</p>
                        <p class="card-text lead"><?php echo htmlspecialchars($actividad['monitor']); ?></p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <div class="btn-group">
                            <a type="button" class="btn btn-success" href="<?php echo $dirHref . '/app/EditarActividades.php?edit_id=' . $actividad['id']; ?>">Modificar</a>

                            <a type="button" class="btn btn-danger" href="<?php echo $dirHref . '/app/ListarActividades.php?delete_id=' . $actividad['id']; ?>">Borrar</a>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        endforeach;
    endif;
    ?>
</div>

<?php
// Incluimos el pie de página
require_once $dir . '/../templates/footer.php';
?>