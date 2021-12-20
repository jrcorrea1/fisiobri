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
  $sql_total = "SELECT count(*) as total FROM cobros WHERE 1=1"; 



  $query_total = $dbconn->query($sql_total);
  $result_total = $query_total->fetch(PDO::FETCH_ASSOC);
  $recordsTotal = $result_total['total'];
  $recordsFiltered = $recordsTotal;
  /****** FINISH - FOR PAGINATION ******/

  /****** BEGIN - TABLE RECORDS AND FILTERING ******/
  $sql = "SELECT id, factura, fechacobro, cliente, monto, formacobro, cheque, banco, id_apertura  from cobros
  WHERE 1=1";




  // LIMIT
  if (isset($request['start'])) {
    $sql .= " LIMIT " . $request['length'] . " OFFSET " . $request['start'];
  }
  // EXECUTE QUERY
  $stmt = $dbconn->query($sql);
  $cobros = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  /****** FINISH - TABLE RECORDS AND FILTERING ******/

  if ($cobros == FALSE) {
    // RESULT FALSE
    $result = FALSE;
  } else {
    // RESULT TRUE
    $result = TRUE;
    foreach ($cobros as $cobro) {
 
      // SETTING UP COLUMNS FOR TABLE
      $row = array();
      $fecha = empty($cobro['fechacobro']) ? null : date("d/m/Y", strtotime($cobro['fechacobro']));

      $row['id'] = $cobro['id'];
      $row['factura'] = $cobro['factura'];
      $row['fecha'] = $fecha;
      $row['monto'] = $cobro['monto'];
      $row['cliente'] = $cobro['cliente'];
      $row['formacobro'] = $cobro['formacobro'];
      $row['cheque'] = $cobro['cheque'];
      $row['banco'] = $cobro['banco'];
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
?>