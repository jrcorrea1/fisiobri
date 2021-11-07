<?php
session_start();
include('../../../conexion.php');

include('../../core/config.php');
$dbconn = getConnection();

// Check if user is logged
if ($_SESSION['idUser']) {

  /****** BEGIN - VARIABLES DEFINITION ******/
  $request = $_REQUEST;
  $recordsTotal = 0;
  $recordsFiltered = 0;
  $column = array(); // array de columnas de la tabla
  $column[0] = "id_caja";
  $column[1] = "fecha_apertura";
  $column[2] = "monto_apertura";
  $column[3] = "fecha_cierre";
  $column[4] = "monto_cierre";
  $column[5] = "estado";
  /****** FINISH - VARIABLES DEFINITION ******/

  /****** BEGIN - FOR PAGINATION ******/
  // GET TOTAL
  $sql_total = "SELECT count(*) as total FROM apertura_cierre WHERE 1=1"; // obtener todos los usuarios que no tengan rol administrador

  $query_total = $dbconn->query($sql_total);
  $result_total = $query_total->fetch(PDO::FETCH_ASSOC);
  $recordsTotal = $result_total['total'];
  $recordsFiltered = $recordsTotal;
  /****** FINISH - FOR PAGINATION ******/

  /****** BEGIN - TABLE RECORDS AND FILTERING ******/
  $sql = 'SELECT id_caja, fecha_apertura, monto_apertura, fecha_cierre, monto_cierre, estado FROM apertura_cierre WHERE 1=1'; // obtener todos los usuarios que no tengan rol administrador

  // SEARCH
 
  // ORDER
  if (isset($request['order'][0]['column'])) {
    $sql .= " ORDER BY " . $column[$request['order'][0]['column']] . " " . $request['order'][0]['dir'];
  }
  // LIMIT
  if (isset($request['start'])) {
    $sql .= " LIMIT " . $request['length'] . " OFFSET " . $request['start'];
  }
  // EXECUTE QUERY
  $stmt = $dbconn->query($sql);
  $apertura = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  /****** FINISH - TABLE RECORDS AND FILTERING ******/

  if ($apertura == FALSE) {
    // RESULT FALSE
    $result = FALSE;
  } else {
    // RESULT TRUE
    $result = TRUE;
    foreach ($apertura as $caja) {
      // SETTING UP COLUMNS FOR TABLE
      $row = array();
      $fecha_apertura = empty($caja['fecha_apertura']) ? null : date("d/m/Y", strtotime($caja['fecha_apertura']));
      $fecha_cierre = empty($caja['fecha_cierre']) ? null : date("d/m/Y", strtotime($caja['fecha_cierre']));

      $row['id'] = $caja['id_caja'];
      $row['fecha_apertura'] = $fecha_apertura;
      $row['monto_apertura'] = $caja['monto_apertura'];
      $row['fecha_cierre'] = $fecha_cierre;
      $row['monto_cierre'] = $caja['monto_cierre'];
      $row['estado'] = $caja['estado'] == 1 ? "Abierta" : "Cerrada";
      array_push($data, $row);
    }
  }

  // RESULT MESSAGE
  $message = $result ? "success" : "Ocurrio un error intentado resolver la solicitud, por favor complete todos los campos o recargue de vuelta la pagina";
  $status = $result ? "success" : "error";
  echo json_encode(
    array(
      "status" => $status,
      "message" => $message,
      "draw" => intval($request['draw']),
      "recordsTotal" => $recordsTotal,
      "recordsFiltered" => $recordsFiltered,
      "data" => $data
    )
  );
} else // NOT LOGGED
{
  print json_encode(array("status" => "error", "message" => "No autorizado"));
}
