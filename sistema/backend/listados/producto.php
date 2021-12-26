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
  $descripcion = $_GET['des'];



  /****** FINISH - VARIABLES DEFINITION ******/

  /****** BEGIN - FOR PAGINATION ******/
  // GET TOTAL
  $sql_total = "SELECT count(*) as total FROM producto WHERE 1=1";

  // FILTROS
  // FILTROS
  if (!empty($descripcion)) {
    $sql_total .= " AND descripcion LIKE '%$descripcion%'";
  }


  $query_total = $dbconn->query($sql_total);
  $result_total = $query_total->fetch(PDO::FETCH_ASSOC);
  $recordsTotal = $result_total['total'];
  $recordsFiltered = $recordsTotal;
  /****** FINISH - FOR PAGINATION ******/

  /****** BEGIN - TABLE RECORDS AND FILTERING ******/
  $sql = "SELECT codproducto, descripcion, existencia, precio, marca, categoria  from producto
  WHERE 1=1";

  // FILTROS
  if (!empty($descripcion)) {
    $sql .= " AND descripcion LIKE '%$descripcion%'";
  }


  // LIMIT
  if (isset($request['start'])) {
    $sql .= " LIMIT " . $request['length'] . " OFFSET " . $request['start'];
  }
  // EXECUTE QUERY
  $stmt = $dbconn->query($sql);
  $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  /****** FINISH - TABLE RECORDS AND FILTERING ******/

  if ($productos == FALSE) {
    // RESULT FALSE
    $result = FALSE;
  } else {
    // RESULT TRUE
    $result = TRUE;
    foreach ($productos as $producto) {
      // SETTING UP COLUMNS FOR TABLE
      $row = array();


      $row['codproducto'] = $producto['codproducto'];
      $row['descripcion'] = $producto['descripcion'];
      $row['precio'] = $producto['precio'];
      $row['marca'] = $producto['marca'];
      $row['existencia'] = $producto['existencia'];
      $row['categoria'] = $producto['categoria'];
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
