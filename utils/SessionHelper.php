<?php
class SessionHelper {

  /**
   * Comprueba si la sesión no está iniciada. En ese caso, la inicia.
   */
  static function startSessionIfNotStarted() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
  }
}
?>