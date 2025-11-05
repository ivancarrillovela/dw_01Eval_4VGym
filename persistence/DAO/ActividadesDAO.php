<?php
require_once 'GenericDAO.php';

class ActividadesDAO extends GenericDAO
{

  //Se define una constante con el nombre de la tabla
  const TABLA_ACTIVIDADES = 'activities';

  /**
   * Obtiene todas las actividades.
   */
  public function selectAll()
  {
    $query = "SELECT * FROM " . ActividadesDAO::TABLA_ACTIVIDADES . " ORDER BY date ASC";
    $result = mysqli_query($this->conn, $query);
    $activities = array();

    while ($activityDB = mysqli_fetch_array($result)) {
      // Creamos un array por cada actividad
      $activity = array(
        'id' => $activityDB["id"],
        'type' => $activityDB["type"],
        'monitor' => $activityDB["monitor"],
        'place' => $activityDB["place"],
        'date' => $activityDB["date"],
      );
      array_push($activities, $activity);
    }
    return $activities;
  }

  /**
   * Selecciona actividades filtrando por fecha (DATE)
   */
  public function selectByDate($date)
  {
    $query = "SELECT * FROM " . ActividadesDAO::TABLA_ACTIVIDADES . " WHERE DATE(date) = ? ORDER BY date ASC";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $date);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $activities = array();

    while ($activityDB = mysqli_fetch_array($result)) {
      $activity = array(
        'id' => $activityDB["id"],
        'type' => $activityDB["type"],
        'monitor' => $activityDB["monitor"],
        'place' => $activityDB["place"],
        'date' => $activityDB["date"],
      );
      array_push($activities, $activity);
    }
    return $activities;
  }

  /**
   * Selecciona una actividad por su ID.
   */
  public function selectById($id)
  {
    $query = "SELECT * FROM " . ActividadesDAO::TABLA_ACTIVIDADES . " WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $activity = null;

    if ($activityDB = mysqli_fetch_array($result)) {
      $activity = array(
        'id' => $activityDB["id"],
        'type' => $activityDB["type"],
        'monitor' => $activityDB["monitor"],
        'place' => $activityDB["place"],
        'date' => $activityDB["date"],
      );
    }
    return $activity; // Devuelve el array de la actividad o null
  }

  /**
   * Inserta una nueva actividad.
   * $dto es un array ['type' => ..., 'monitor' => ..., 'place' => ..., 'date' => ...]
   */
  public function insert($dto)
  {
    $query = "INSERT INTO " . ActividadesDAO::TABLA_ACTIVIDADES .
      " (type, monitor, place, date) VALUES(?,?,?,?)";
    $stmt = mysqli_prepare($this->conn, $query);

    // 'ssss' = 4 strings (type, monitor, place, date)
    mysqli_stmt_bind_param(
      $stmt,
      'ssss',
      $dto['type'],
      $dto['monitor'],
      $dto['place'],
      $dto['date']
    );
    return $stmt->execute();
  }

  /**
   * Actualiza una actividad existente.
   * $dto es un array ['id' => ..., 'type' => ..., 'monitor' => ..., 'place' => ..., 'date' => ...]
   */
  public function update($dto)
  {
    $query = "UPDATE " . ActividadesDAO::TABLA_ACTIVIDADES .
      " SET type=?, monitor=?, place=?, date=?"
      . " WHERE id=?";
    $stmt = mysqli_prepare($this->conn, $query);

    // 'ssssi' = 4 strings y 1 integer (id)
    mysqli_stmt_bind_param(
      $stmt,
      'ssssi',
      $dto['type'],
      $dto['monitor'],
      $dto['place'],
      $dto['date'],
      $dto['id']
    );
    return $stmt->execute();
  }

  /**
   * Borra una actividad por su ID.
   */
  public function delete($id)
  {
    $query = "DELETE FROM " . ActividadesDAO::TABLA_ACTIVIDADES . " WHERE id = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return $stmt->execute();
  }
}
