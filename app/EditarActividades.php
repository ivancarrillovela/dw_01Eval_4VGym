<?php
// Configuración de rutas
$dir = __DIR__;
$dirHref = '/EjerciciosDWEB/dw_01Eval_4VGym';

// Gestión de sesión
require_once $dir . '/../utils/GestorSesion.php';
GestorSesion::iniciarSesionSiNoEstaIniciada();
$_SESSION['last_page'] = 'EditarActividades.php'; // Guardamos la URL completa

// Incluimos el DAO
require_once $dir . '/../persistence/DAO/ActividadesDAO.php';

// Incluimos el validador
require_once $dir . '/../utils/Validador.php';

// Definimos las variables para la lógica de la vista
$errores = []; // Array para almacenar errores de validación
$actividadDAO = new ActividadesDAO();

// Variables para el formulario (se rellenarán con GET o POST)
$id_actividad = null;
$valor_tipo = '';
$valor_monitor = '';
$valor_lugar = '';
$valor_fecha = '';


// --- ACTUALIZAR (POST) --- 
// Comprobamos si la petición es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperamos los datos del POST
    $id_actividad = $_POST['id'] ?? null;
    $valor_tipo = $_POST['type'] ?? '';
    $valor_monitor = $_POST['monitor'] ?? '';
    $valor_lugar = $_POST['place'] ?? '';
    $valor_fecha = $_POST['date'] ?? '';

    // Validamos usando el validador
    $errores = Validador::validarForm([
        'id' => $id_actividad,
        'type' => $valor_tipo,
        'monitor' => $valor_monitor,
        'place' => $valor_lugar,
        'date' => $valor_fecha
    ], true); // true porque requiere ID al editar

    // Si no hay errores actualizamos
    if (empty($errores)) {
        $actividadDTO = [
            'id' => $id_actividad,
            'type' => $valor_tipo,
            'monitor' => $valor_monitor,
            'place' => $valor_lugar,
            'date' => $valor_fecha
        ];

        $actividadDAO->update($actividadDTO);

        // Redirigimos al listado
        header("Location: " . $dirHref . "/app/ListarActividades.php");
        exit;
    }
    // Si hay errores, se mostrarán en la vista
}

// --- OBTENER (GET) --- 
else if (isset($_GET['edit_id'])) {
    $id_actividad = $_GET['edit_id'];

    // Asegurarnos de que el ID existe
    $actividad = $actividadDAO->selectById($id_actividad);

    if ($actividad) {
        // Si existe, rellenamos las variables para el formulario
        $valor_tipo = $actividad['type'];
        $valor_monitor = $actividad['monitor'];
        $valor_lugar = $actividad['place'];
        $valor_fecha = $actividad['date'];
    } else {
        // Si no existe, redirigimos al listado
        header("Location: " . $dirHref . "/app/ListarActividades.php");
        exit;
    }
}

// --- LÓGICA ACCESO INVÁLIDO ---
// Si no es POST ni GET con edit_id es incorrecto
else {
    header("Location: " . $dirHref . "/app/ListarActividades.php");
    exit;
}

// --- VISTA ---
require_once $dir . '/../templates/header.php';
?>

<h2>Editar Actividad (ID: <?php echo $id_actividad; ?>)</h2>
<hr>

<?php
// Si hay errores (del POST), los mostramos
if (!empty($errores)) {
    echo '<div class="alert alert-danger" role="alert">';
    foreach ($errores as $error) {
        echo "<p class='mb-0'>$error</p>";
    }
    echo '</div>';
}
?>

<?php
// Variables para el formulario reutilizable
$form_action = $dirHref . '/app/EditarActividades.php';
$button_text = 'Edit';
// $id_actividad, $valor_tipo, etc., ya están definidas arriba

// Incluimos el formulario reutilizable
require $dir . '/../templates/formulario.php';
?>

<?php
require_once $dir . '/../templates/footer.php';
?>