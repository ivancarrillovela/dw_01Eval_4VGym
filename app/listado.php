<?php
// (Paso 2) Gestión de sesión
require_once __DIR__ . '/../utils/SessionHelper.php';
SessionHelper::startSessionIfNotStarted();
$_SESSION['last_page'] = 'listado.php'; // Guardamos la última página visitada [cite: 82]

// Incluimos el DAO
require_once __DIR__ . '/../persistence/DAO/ActivityDAO.php';

// Creamos la instancia del DAO
$activityDAO = new ActivityDAO();

// --- LÓGICA PASO 5: BORRAR ACTIVIDAD --- [cite: 148]
// Comprobamos si nos llega una petición GET para borrar [cite: 150]
if (isset($_GET['delete_id'])) {
    $id_a_borrar = $_GET['delete_id'];
    
    // (Paso 5.1) Verificar que el ID existe antes de borrar [cite: 153]
    $actividad_existe = $activityDAO->selectById($id_a_borrar);
    
    if ($actividad_existe) {
        // (Paso 5.1b) Si existe, se elimina [cite: 155]
        $activityDAO->delete($id_a_borrar);
    }
    // (Paso 5.1a) Si no existe, no hacemos nada [cite: 154]
    
    // Redirigimos a listado.php para limpiar la URL (refrescar listado) [cite: 155]
    header("Location: listado.php");
    exit;
}
// --- FIN LÓGICA PASO 5 ---


// --- LÓGICA PASO 7: FILTRAR POR FECHA --- [cite: 189]
$filter_date = null;
// Validamos que la fecha esté presente y no esté vacía [cite: 192]
if (isset($_GET['activityDate']) && !empty($_GET['activityDate'])) {
    // (Idealmente se validaría el formato YYYY-MM-DD)
    $filter_date = $_GET['activityDate'];
    // Buscamos en el servidor [cite: 190, 191]
    $activities = $activityDAO->selectByDate($filter_date);
} else {
    // --- LÓGICA PASO 3: MOSTRAR TODO --- [cite: 95]
    $activities = $activityDAO->selectAll();
}
// --- FIN LÓGICA PASO 7 ---


// --- VISTA ---
// Incluimos la cabecera
require_once __DIR__ . '/../templates/header.php';
?>

<div class="alert alert-warning">
    <div class="row">
        <div class="col-md-5">
            <img class="img-fluid img-rounded" src="../assets/img/main-logo.png" alt="">
        </div>
        <div class="col-md-7">
            <h1>4VGym, GYM de 4V</h1>
            <p>Ponte en forma y ganaras vida</p>
            <hr />
            <form action="listado.php" method="get" class="row g-2 align-items-center">
                <div class="col-auto">
                    <input name="activityDate" id="activityDate" class="form-control" type="date" value="<?php echo htmlspecialchars($filter_date ?? ''); ?>" />
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
    // (Paso 7) Comprobar si hay resultados [cite: 194]
    if (empty($activities)) :
    ?>
        <div class="col-12">
            <div class="alert alert-info" role="alert">
                No hay resultados para la fecha seleccionada.
            </div>
        </div>
    <?php
    // (Paso 3) Si hay actividades, las mostramos
    else :
        foreach ($activities as $activity) :
            // Lógica para la imagen [cite: 101, 102]
            $image_path = '../assets/img/main-logo.png'; // Imagen por defecto
            if ($activity['type'] === 'bodypump') {
                $image_path = '../assets/img/bodypump.png';
            } elseif ($activity['type'] === 'spinning') {
                $image_path = '../assets/img/spinning2.png';
            } elseif ($activity['type'] === 'pilates') {
                $image_path = '../assets/img/pilates.png';
            }
    ?>
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img class="card-img-top w-50 p-3 img-fluid mx-auto" src='<?php echo $image_path; ?>' alt="<?php echo $activity['type']; ?>">
                    <div class="card-body">
                        <h2 class="card-title display-4"><?php echo htmlspecialchars($activity['place']); ?></h2>
                        <p class="card-text lead"><?php echo date('d M Y H:i', strtotime($activity['date'])); ?>h</p>
                        <p class="card-text lead"><?php echo htmlspecialchars($activity['monitor']); ?></p>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <div class="btn-group">
                            <a type="button" class="btn btn-success" href="editarActividad.php?edit_id=<?php echo $activity['id']; ?>">Modificar</a>
                            
                            <a type="button" class="btn btn-danger" href="listado.php?delete_id=<?php echo $activity['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres borrar esta actividad?');">Borrar</a>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        endforeach;
    endif; // Fin del if (empty($activities))
    ?>
</div>

<?php
// Incluimos el pie de página
require_once __DIR__ . '/../templates/footer.php';
?>