<?php
// Usamos el helper de sesión de la arquitectura de clase
require_once 'utils/SessionHelper.php';
SessionHelper::startSessionIfNotStarted(); // [cite: 377]

// Comprobamos la variable de sesión 'last_page'
if (isset($_SESSION['last_page'])) {
    // Si hay sesión, redirige a la última página vista [cite: 82]
    header('Location: app/' . $_SESSION['last_page']);
    exit; // Aseguramos que el script termina tras la redirección
} else {
    // Si no hay sesión, al listado de actividades [cite: 81]
    header('Location: app/listado.php');
    exit; // Aseguramos que el script termina tras la redirección
}

?>