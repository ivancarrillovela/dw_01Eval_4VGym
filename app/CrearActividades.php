<?php
// Configuración de rutas
$dir = __DIR__;
$dirHref = '/EjerciciosDWEB/dw_01Eval_4VGym';

// Gestión de sesión
require_once $dir . '/../utils/GestorSesion.php';
GestorSesion::iniciarSesionSiNoEstaIniciada();
$_SESSION['last_page'] = 'CrearActividades.php'; // Guardamos la última página visitada

// Incluimos el DAO
require_once $dir . '/../persistence/DAO/ActividadesDAO.php';

// Incluimos el validador
require_once $dir . '/../utils/Validador.php';

// Definimos las variables para la lógica de la vista
$errores = []; // Array para almacenar errores de validación
$actividadDAO = null;

// Valores por defecto para el formulario
$valor_tipo = '';
$valor_monitor = '';
$valor_lugar = '';
$valor_fecha = '';

// --- CREAR (POST) ---
// Comprobamos si la petición es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperamos los datos del formulario
    $valor_tipo = $_POST['type'] ?? '';
    $valor_monitor = $_POST['monitor'] ?? '';
    $valor_lugar = $_POST['place'] ?? '';
    $valor_fecha = $_POST['date'] ?? '';

    // Validamos usando el validador
    $errores = Validador::validarForm([
        'type' => $valor_tipo,
        'monitor' => $valor_monitor,
        'place' => $valor_lugar,
        'date' => $valor_fecha
    ], false); // false porque no requiere ID al crear ya que en la BBDD es autoincremental

    // Si no hay errores insertamos
    if (empty($errores)) {
        $actividadDAO = new ActividadesDAO();

        $actividadDTO = [
            'type' => $valor_tipo,
            'monitor' => $valor_monitor,
            'place' => $valor_lugar,
            'date' => $valor_fecha
        ];

        $actividadDAO->insert($actividadDTO);

        // Redirigimos al listado 
        header("Location: " . $dirHref . "/app/ListarActividades.php");
        exit;
    }
    // Si hay errores se mostrarán en la vista
}

// --- VISTA ---
// Incluimos la cabecera
require_once $dir . '/../templates/header.php';
?>

<h2>Crear Nueva Actividad</h2>
<hr>

<?php
// Si hay errores, los mostramos en pantalla
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
$form_action = $dirHref . '/app/CrearActividades.php';
$button_text = 'Insertar';
$id_actividad = null; // No hay ID en la creación

// Incluimos el formulario reutilizable
require $dir . '/../templates/formulario.php';
?>

<?php
// Incluimos el pie de página
require_once $dir . '/../templates/footer.php';
?>