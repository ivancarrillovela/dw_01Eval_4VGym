<?php
// Configuración de rutas
$dir = __DIR__;
$dirHref = '/EjerciciosDWEB/dw_01Eval_4VGym';

// Iniciamos sesión en todas las páginas para guardar la última visita
require_once $dir . '/../utils/GestorSesion.php';
GestorSesion::iniciarSesionSiNoEstaIniciada();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>4VGym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/octicons/3.5.0/octicons.min.css">
</head>
<body>

    <nav class="navbar navbar-light navbar-expand-md" role="navigation">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $dirHref . '/app/listado.php'; ?>"> 
                <img class="img-fluid rounded d-inline-block align-top" src="<?php echo $dirHref . '/assets/img/small-logo_1.jpg'; ?>" alt="" width="30" height="30">
                4VGYM
            </a>
            
            <div class="ml-auto">
                <a type="button" class="btn btn-info" href="<?php echo $dirHref . '/app/crearActividad.php'; ?>">
                    <span class="octicon octicon-cloud-upload"></span> Subir Actividad
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">