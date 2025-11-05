<?php
// (Paso 2) Gestión de sesión
require_once __DIR__ . '/../utils/SessionHelper.php';
SessionHelper::startSessionIfNotStarted();
$_SESSION['last_page'] = 'crearActividad.php'; // [cite: 82]

// Incluimos el DAO
require_once __DIR__ . '/../persistence/DAO/ActivityDAO.php';

// Definimos las variables para la lógica de la vista
$errors = []; // Array para almacenar errores de validación
$activityDAO = null;

// Valores por defecto para el formulario (vacíos)
$type_value = '';
$monitor_value = '';
$place_value = '';
$date_value = '';

// Constantes para validación [cite: 126]
define("VALID_TYPES", ['spinning', 'bodypump', 'pilates']);

// --- LÓGICA PASO 4: CREAR (POST) ---
// Comprobamos si la petición es POST [cite: 129]
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recuperamos los datos del formulario
    $type_value = $_POST['type'] ?? '';
    $monitor_value = $_POST['monitor'] ?? '';
    $place_value = $_POST['place'] ?? '';
    $date_value = $_POST['date'] ?? '';

    // --- Validaciones [cite: 124] ---
    
    // (Paso 4.1) Todos los campos obligatorios [cite: 125]
    if (empty($type_value) || empty($monitor_value) || empty($place_value) || empty($date_value)) {
        $errors[] = "Todos los campos son obligatorios.";
    }

    // (Paso 4.2) Tipo de Actividad válida [cite: 126]
    if (!in_array($type_value, VALID_TYPES)) {
        $errors[] = "El tipo de actividad no es válido. Debe ser 'spinning', 'bodypump' o 'pilates'.";
    }

    // (Paso 4.3) Fecha posterior a la actual [cite: 127]
    // Usamos strtotime (visto en UT1 [cite: 431] para time()) para convertir la fecha a timestamp
    $date_timestamp = strtotime($date_value);
    $now_timestamp = time();

    if ($date_timestamp === false || $date_timestamp < $now_timestamp) {
        $errors[] = "La fecha y hora deben ser posteriores a la fecha y hora actual.";
    }
    
    // --- Fin Validaciones ---

    // Si no hay errores, procedemos a insertar 
    if (empty($errors)) {
        $activityDAO = new ActivityDAO();
        
        $activityDTO = [
            'type' => $type_value,
            'monitor' => $monitor_value,
            'place' => $place_value,
            'date' => $date_value
        ];
        
        $activityDAO->insert($activityDTO);
        
        // Redirigimos al listado 
        header("Location: listado.php");
        exit;
    }
    // Si hay errores[cite: 130], se mostrarán en la vista
}
// --- FIN LÓGICA PASO 4 ---

// --- VISTA ---
// Incluimos la cabecera
require_once __DIR__ . '/../templates/header.php';
?>

<h2>Crear Nueva Actividad</h2>
<hr>

<?php
// (Paso 4.4) Si hay errores, los mostramos en pantalla [cite: 130]
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
$form_action = 'crearActividad.php';
$button_text = 'Insert';
$activity_id = null; // No hay ID en la creación

// (Paso 6) Incluimos el formulario reutilizable [cite: 165]
require __DIR__ . '/../templates/formActividad.php';
?>

<?php
// Incluimos el pie de página
require_once __DIR__ . '/../templates/footer.php';
?>