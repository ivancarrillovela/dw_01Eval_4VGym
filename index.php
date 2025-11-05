<?php
// Configuración de rutas
$dir = __DIR__;
$dirHref = '/EjerciciosDWEB/dw_01Eval_4VGym';

// Usamos el helper de sesión de la arquitectura de clase
require_once $dir . '/utils/GestorSesion.php';

// Iniciamos sesión en todas las páginas para guardar la última visita
GestorSesion::iniciarSesionSiNoEstaIniciada();

// Comprobamos la variable de sesión 'last_page'
if (isset($_SESSION['last_page'])) {
    // Si hay sesión, redirige a la última página vista
    header('Location: ' . $dirHref . '/app/' . $_SESSION['last_page']);
    exit; // Aseguramos que el script termina tras la redirección
} else {
    // Si no hay sesión, al listado de actividades
    header('Location: ' . $dirHref . '/app/ListarActividades.php');
    exit; // Aseguramos que el script termina tras la redirección
}
