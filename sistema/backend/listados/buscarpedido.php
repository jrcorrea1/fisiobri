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




  /****** FINISH - VARIABLES DEFINITION ******/

  /****** BEGIN - FOR PAGINATION ******/
  // GET TOTAL
  $sql_total = "SELECT count(*) as total FROM pedido_compra WHERE 1=1 AND estado='Pendiente'";

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
  $sql = "SELECT p.id, p.fecha, p.proveedor_id, p.sucursa_id, p.usuario_id, p.estado,
  u.nombre, s.nombre as sucursal, pr.proveedor
  FROM pedido_compra as p INNER JOIN proveedor as pr ON p.proveedor_id = pr.codproveedor
  INNER JOIN sucursal as s ON p.sucursa_id = s.idsucursal
  INNER JOIN usuario as u ON p.usuario_id = u.idusuario
   WHERE 1=1 AND p.estado='Pendiente'";

  




  // EXECUTE QUERY
  $stmt = $dbconn->query($sql);
  $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  /****** FINISH - TABLE RECORDS AND FILTERING ******/

  if ($pedidos == FALSE) {
    // RESULT FALSE
    $result = FALSE;
  } else {
    // RESULT TRUE
    $result = TRUE;
    foreach ($pedidos as $pedido) {
      // SETTING UP COLUMNS FOR TABLE
      $row = array();

      $fecha = empty($pedido['fecha']) ? null : date("d/m/Y", strtotime($pedido['fecha']));


      $row['id'] = $pedido['id'];
      $row['fechapedido'] = $fecha;
      $row['proveedor_id'] = $pedido['proveedor_id'];
      $row['proveedor'] = $pedido['proveedor'];
      $row['sucursa_id'] = $pedido['sucursa_id'];
      $row['sucursal'] = $pedido['sucursal'];
      $row['usuario'] = $pedido['nombre'];
      $row['estado'] = $pedido['estado'];
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
