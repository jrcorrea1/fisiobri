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
  $des = $_GET['nombre'];




  /****** FINISH - VARIABLES DEFINITION ******/

  /****** BEGIN - FOR PAGINATION ******/
  // GET TOTAL
  $sql_total = "SELECT count(*) as total FROM barrio WHERE 1=1"; 

  if (!empty($des)) {
    $sql_total .= " AND barrio LIKE '%$des%'";
  }


  $query_total = $dbconn->query($sql_total);
  $result_total = $query_total->fetch(PDO::FETCH_ASSOC);
  $recordsTotal = $result_total['total'];
  $recordsFiltered = $recordsTotal;
  /****** FINISH - FOR PAGINATION ******/

  /****** BEGIN - TABLE RECORDS AND FILTERING ******/
  $sql = "SELECT id, barrio, estado, ciudad, departamento  from barrio
  WHERE 1=1";

if (!empty($des)) {
  $sql .= " AND barrio LIKE '%$des%'";
}



  // LIMIT
  if (isset($request['start'])) {
    $sql .= " LIMIT " . $request['length'] . " OFFSET " . $request['start'];
  }
  // EXECUTE QUERY
  $stmt = $dbconn->query($sql);
  $barrios = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  /****** FINISH - TABLE RECORDS AND FILTERING ******/

  if ($barrios == FALSE) {
    // RESULT FALSE
    $result = FALSE;
  } else {
    // RESULT TRUE
    $result = TRUE;
    foreach ($barrios as $barrio) {
 
      // SETTING UP COLUMNS FOR TABLE
      $row = array();


      $row['id'] = $barrio['id'];
      $row['barrio'] = $barrio['barrio'];
      $row['departamento'] = $barrio['departamento'];
      $row['ciudad'] = $barrio['ciudad'];
      $row['estado'] = $barrio['estado'];
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