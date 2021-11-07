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
  $pedido = $_GET['pedido'];
 
  
  // session variables

  /****** FINISH - VARIABLES DEFINITION ******/

  /****** BEGIN - FOR PAGINATION ******/
  // GET TOTAL
  $sql_total = "SELECT count(*) as total FROM detalle_pedido WHERE 1=1";

  if(!empty($pedido)){
    $sql_total .= " AND id_pedido=$pedido";
  }

  
  
  $query_total = $dbconn->query($sql_total);
  $result_total = $query_total->fetch(PDO::FETCH_ASSOC);
  $recordsTotal = $result_total['total'];
  $recordsFiltered = $recordsTotal;

  /****** FINISH - FOR PAGINATION ******/

  /****** BEGIN - TABLE RECORDS AND FILTERING ******/
  $sql = "SELECT dp.id_pedido, dp.id_producto, p.descripcion, p.marca, p.precio, dp.cantidad
  from detalle_pedido dp inner join producto p on dp.id_producto = p.codproducto 
   WHERE 1=1";
  
  if(!empty($pedido)){
    $sql .= " AND id_pedido= $pedido";
  }
 
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
        $row['id_pedido'] = $producto['id_pedido'];       
        $row['descripcion'] = $producto['descripcion'];
        $row['cantidad'] = $producto['cantidad'];  
        $row['precio'] = $producto['precio'];   
        $row['total'] = $total;       
        $row['marca'] = $producto['marca'];       
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
