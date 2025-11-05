<?php
// Incluimos el PersistentManager
require_once __DIR__ . '/../conf/PersistentManager.php';

abstract class GenericDAO {

  //Conexión a BD
  protected $conn = null;
  //Constructor de la clase
  public function __construct() {
    $this->conn = PersistentManager::getInstance()->get_connection();
  }

  // métodos abstractos para CRUD de clases que hereden
  // Adaptados a la entidad 'Activity' del examen
  abstract protected function selectAll();
  abstract protected function selectById($id);
  abstract protected function insert($dto); // DTO (Data Transfer Object) será un array
  abstract protected function update($dto); // DTO será un array
  abstract protected function delete($id);

}
?>