<?php
class GestorSesion {

  /**
   * Comprueba si la sesión no está iniciada. En ese caso la inicia.
   */
  static function iniciarSesionSiNoEstaIniciada() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
  }
}
?>