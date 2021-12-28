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

  $fecha_array = explode("/", $_GET['desde']);
  $desde = empty($_GET['desde']) ? NULL : $fecha_array[2] . "-" . $fecha_array[1] . "-" . $fecha_array[0];
  $fecha_array2 = explode("/", $_GET['hasta']);
  $hasta = empty($_GET['hasta']) ? NULL : $fecha_array2[2] . "-" . $fecha_array2[1] . "-" . $fecha_array2[0];




  /****** FINISH - VARIABLES DEFINITION ******/

  /****** BEGIN - FOR PAGINATION ******/
  // GET TOTAL
  $sql_total = "SELECT count(*) as total FROM factura WHERE 1=1";

  // FILTROS


  if (!empty($desde) && !empty($hasta)) {
    $sql_total .= " AND fecha BETWEEN '$desde' AND '$hasta'";
  }
  


  $query_total = $dbconn->query($sql_total);
  $result_total = $query_total->fetch(PDO::FETCH_ASSOC);
  $recordsTotal = $result_total['total'];
  $recordsFiltered = $recordsTotal;
  /****** FINISH - FOR PAGINATION ******/

  /****** BEGIN - TABLE RECORDS AND FILTERING ******/
  $sql = "SELECT f.nofactura, f.fecha,f.codcliente,c.dni, c.nombre, c.apellido, f.totalfactura, f.estado 
  FROM factura as f INNER JOIN cliente as c ON f.codcliente=c.idcliente
  WHERE 1=1";

  // FILTROS

 
  if (!empty($desde) && !empty($hasta)) {
    $sql .= " AND f.fecha BETWEEN '$desde' AND '$hasta'";
  }
 


  // LIMIT
  if (isset($request['start'])) {
    $sql .= " LIMIT " . $request['length'] . " OFFSET " . $request['start'];
  }
  // EXECUTE QUERY
  $stmt = $dbconn->query($sql);
  $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  /****** FINISH - TABLE RECORDS AND FILTERING ******/

  if ($facturas == FALSE) {
    // RESULT FALSE
    $result = FALSE;
  } else {
    // RESULT TRUE
    $result = TRUE;
    foreach ($facturas as $factura) {
      // SETTING UP COLUMNS FOR TABLE
      $row = array();

      $fecha = date("d/m/Y", strtotime($factura['fecha']));


      $row['nofactura'] = $factura['nofactura'];
      $row['codcliente'] = $factura['codcliente'];
      $row['cliente'] = $factura['dni'].' - '.$factura['nombre'].' '.$factura['apellido'];
      $row['fecha'] = $fecha;
      $row['totalfactura'] = $factura['totalfactura'];
      $row['estado'] = $factura['estado'];
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
