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
  $sql_total = "SELECT count(*) as total FROM factura WHERE 1=1 AND estado=1";

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
  $sql = "SELECT f.nofactura, f.fecha, f.usuario, f.codcliente,c.dni, c.nombre,c.apellido, f.totalfactura, f.estado FROM factura as f
  INNER JOIN cliente as c ON f.codcliente=c.idcliente
    WHERE 1=1 AND estado=1";
  
  




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

      $fecha = empty($factura['fecha']) ? null : date("d/m/Y", strtotime($factura['fecha']));
      $cliente = $factura['dni']." - ".$factura['nombre'] . " " . $factura['apellido'];


      $row['id'] = $factura['nofactura'];
      $row['fecha'] = $fecha;
      $row['cliente'] = $cliente;
      $row['monto'] = $factura['totalfactura'];
      $row['usuario'] = $factura['usuario'];
    
      $row['usuario'] = $factura['nombre'];
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
