<?php
// (Paso 2) Gestión de sesión
require_once __DIR__ . '/../utils/SessionHelper.php';
SessionHelper::startSessionIfNotStarted();
$_SESSION['last_page'] = basename($_SERVER['REQUEST_URI']); // Guardamos la URL completa (incl. ?edit_id=)

// Incluimos el DAO
require_once __DIR__ . '/../persistence/DAO/ActivityDAO.php';

$errors = [];
$activityDAO = new ActivityDAO();

// Constantes para validación [cite: 126]
define("VALID_TYPES", ['spinning', 'bodypump', 'pilates']);

// Variables para el formulario (se rellenarán con GET o POST)
$activity_id = null;
$type_value = '';
$monitor_value = '';
$place_value = '';
$date_value = '';


// --- LÓGICA PASO 6: ACTUALIZAR (POST) --- 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperamos los datos del POST
    $activity_id = $_POST['id'] ?? null;
    $type_value = $_POST['type'] ?? '';
    $monitor_value = $_POST['monitor'] ?? '';
    $place_value = $_POST['place'] ?? '';
    $date_value = $_POST['date'] ?? '';

    // --- Validaciones (IDÉNTICAS a crear) [cite: 168] ---
    if (empty($activity_id) || empty($type_value) || empty($monitor_value) || empty($place_value) || empty($date_value)) {
        $errors[] = "Todos los campos son obligatorios.";
    }
    if (!in_array($type_value, VALID_TYPES)) {
        $errors[] = "El tipo de actividad no es válido.";
    }
    $date_timestamp = strtotime($date_value);
    $now_timestamp = time();
    if ($date_timestamp === false || $date_timestamp < $now_timestamp) {
        $errors[] = "La fecha y hora deben ser posteriores a la actual.";
    }
    // --- Fin Validaciones ---

    // Si no hay errores, actualizamos
    if (empty($errors)) {
        $activityDTO = [
            'id' => $activity_id,
            'type' => $type_value,
            'monitor' => $monitor_value,
            'place' => $place_value,
            'date' => $date_value
        ];
        
        $activityDAO->update($activityDTO);
        
        // Redirigimos al listado
        header("Location: listado.php");
        exit;
    }
    // Si hay errores, se mostrarán en la vista
}

// --- LÓGICA PASO 6: OBTENER (GET) --- 
else if (isset($_GET['edit_id'])) {
    $activity_id = $_GET['edit_id'];
    
    // (Paso 6.1) Asegurarnos de que el ID existe [cite: 166]
    $activity = $activityDAO->selectById($activity_id);
    
    if ($activity) {
        // Si existe, rellenamos las variables para el formulario
        $type_value = $activity['type'];
        $monitor_value = $activity['monitor'];
        $place_value = $activity['place'];
        $date_value = $activity['date'];
    } else {
        // (Paso 6.2) Si no existe, redirigimos al listado [cite: 167]
        header("Location: listado.php");
        exit;
    }
}

// --- LÓGICA ACCESO INVÁLIDO ---
// Si no es POST ni GET con 'edit_id', es un acceso incorrecto
else {
    header("Location: listado.php");
    exit;
}

// --- VISTA ---
require_once __DIR__ . '/../templates/header.php';
?>

<h2>Editar Actividad (ID: <?php echo $activity_id; ?>)</h2>
<hr>

<?php
// (Paso 4.4) Si hay errores (del POST), los mostramos [cite: 130]
if (!empty($errors)) {
    echo '<div class="alert alert-danger" role="alert">';
    foreach ($errors as $error) {
        echo "<p class='mb-0'>$error</p>";
    }
    echo '</div>';
}
?>

<?php
// Variables para el formulario reutilizable
$form_action = 'editarActividad.php';
$button_text = 'Edit';
// $activity_id, $type_value, etc., ya están definidas arriba

// Incluimos el formulario reutilizable [cite: 165]
require __DIR__ . '/../templates/formActividad.php';
?>

<?php
require_once __DIR__ . '/../templates/footer.php';
?>