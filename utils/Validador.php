<?php

class Validador
{
    // Constantes para validación
    const TIPOS_VALIDOS = ['spinning', 'bodypump', 'pilates'];

    /**
     * Valida los datos de una actividad
     * 
     * @param array $datos Array con los datos a validar: type, monitor, place y date
     * @param bool $requiereId Si se requiere validar el campo 'id' (true para editar, false para crear)
     * @return array Array de errores (vacío si no hay errores)
     */
    public static function validarForm($datos, $requiereId = false)
    {
        $errores = [];

        // Extraemos los datos
        $id = $datos['id'] ?? null;
        $tipo = $datos['type'] ?? '';
        $monitor = $datos['monitor'] ?? '';
        $lugar = $datos['place'] ?? '';
        $fecha = $datos['date'] ?? '';

        // Validación de campos obligatorios
        if ($requiereId && empty($id)) {
            $errores[] = "El ID de la actividad es obligatorio.";
        }

        if (empty($tipo) || empty($monitor) || empty($lugar) || empty($fecha)) {
            $errores[] = "Todos los campos son obligatorios.";
        }

        // Validación del tipo de actividad
        if (!empty($tipo) && !in_array($tipo, self::TIPOS_VALIDOS)) {
            $errores[] = "El tipo de actividad no es válido. Debe ser 'spinning', 'bodypump' o 'pilates'.";
        }

        // Validación de fecha posterior a la actual
        if (!empty($fecha)) {
            $timestamp_fecha = strtotime($fecha);
            $timestamp_ahora = time();

            if ($timestamp_fecha === false || $timestamp_fecha < $timestamp_ahora) {
                $errores[] = "La fecha y hora deben ser posteriores a la fecha y hora actual.";
            }
        }

        return $errores;
    }

    /**
     * Valida una fecha en formato YYYY-MM-DD
     * 
     * @param string $fecha Fecha a validar en formato YYYY-MM-DD
     * @return bool True si la fecha es válida, false en caso contrario
     */
    public static function validarFormatoFecha($fecha)
    {
        // Validar que no esté vacía
        if (empty($fecha)) {
            return false;
        }

        // Validar formato YYYY-MM-DD usando expresión regular
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            return false;
        }

        // Separar la fecha en componentes
        $partes = explode('-', $fecha);
        if (count($partes) !== 3) {
            return false;
        }

        $anio = (int)$partes[0];
        $mes = (int)$partes[1];
        $dia = (int)$partes[2];

        // Validar que sea una fecha real del calendario (por ejemplo no permite 2024-13-45)
        return checkdate($mes, $dia, $anio);
    }
}
