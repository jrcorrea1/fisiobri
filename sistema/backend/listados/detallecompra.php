<?php
session_start();
include('../../../conexion.php');

include('../../core/config.php');
$dbconn = getConnection();



// Check if user is logged
if ($_SESSION['idUser']) {



  /****** BEGIN - VARIABLES DEFINITION ******/
  // GET variables
  $request = $_REQUEST;
  $recordsTotal = 0;
  $recordsFiltered = 0;
  $compra = $_GET['compra'];
 
  
  // session variables

  /****** FINISH - VARIABLES DEFINITION ******/

  /****** BEGIN - FOR PAGINATION ******/
  // GET TOTAL
  $sql_total = "SELECT count(*) as total FROM detalle_compra WHERE 1=1 AND id_compra= $compra";

  if(!empty($compra)){
    $sql_total .= " AND id_compra = $compra";
  }

  
  
  $query_total = $dbconn->query($sql_total);
  $result_total = $query_total->fetch(PDO::FETCH_ASSOC);
  $recordsTotal = $result_total['total'];
  $recordsFiltered = $recordsTotal;

  /****** FINISH - FOR PAGINATION ******/

  /****** BEGIN - TABLE RECORDS AND FILTERING ******/
  $sql = "SELECT dp.id_compra, dp.id_producto, p.existencia, p.descripcion, p.marca, p.precio, dp.cantidad
  from detalle_compra dp inner join producto p on dp.id_producto = p.codproducto 
   WHERE 1=1 AND dp.id_compra= $compra";
  
 
 
  // LIMIT
  if(isset($request['start'])){
    $sql .= " LIMIT ".$request['length']." OFFSET ".$request['start'];
  }
  // EXECUTE QUERY
  $stmt = $dbconn->query($sql);
  $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  /****** FINISH - TABLE RECORDS AND FILTERING ******/
  
  if($productos == FALSE)
  {
    // RESULT FALSE
    $result = FALSE;
  }
  else
  {
    // RESULT TRUE
    $result = TRUE;
    foreach ($productos as $producto) {
        // SETTING UP COLUMNS FOR TABLE
        $row = array();

        $total = $producto['precio'] * $producto['cantidad'];
    
       
        
        $row['codigo'] = $producto['id_producto'];  
        $row['id_compra'] = $producto['id_compra'];       
        $row['descripcion'] = $producto['descripcion'];
        $row['cantidad'] = $producto['cantidad'];  
        $row['precio'] = $producto['precio'];   
        $row['total'] = $total;       
        $row['marca'] = $producto['marca'];  
        $row['existencia'] = $producto['existencia'];     
      //  var_dump($row);      
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
      "data" => $data)
  );

}
else // NOT LOGGED
{
	print json_encode(array("status" => "error", "message" => "No autorizado"));
}
