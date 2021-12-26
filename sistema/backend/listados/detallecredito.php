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
  $factura = empty($_GET['factura']) ? 0 : $_GET['factura'];
 
  
  // session variables

  /****** FINISH - VARIABLES DEFINITION ******/

  /****** BEGIN - FOR PAGINATION ******/
  // GET TOTAL
  $sql_total = "SELECT count(*) as total FROM detallefactura WHERE 1=1 AND nofactura= $factura";
  
 

  
  
  $query_total = $dbconn->query($sql_total);
  $result_total = $query_total->fetch(PDO::FETCH_ASSOC);
  $recordsTotal = $result_total['total'];
  $recordsFiltered = $recordsTotal;

  /****** FINISH - FOR PAGINATION ******/

  /****** BEGIN - TABLE RECORDS AND FILTERING ******/
  $sql = "SELECT d.nofactura, d.codproducto, d.cantidad, p.descripcion, p.marca, d.precio_venta 
  FROM detallefactura as d INNER JOIN producto as p ON d.codproducto = p.codproducto 
   WHERE 1=1 AND d.nofactura= $factura";
  
 
  // LIMIT
  if(isset($request['start'])){
    $sql .= " LIMIT ".$request['length']." OFFSET ".$request['start'];
  }
  // EXECUTE QUERY
  $stmt = $dbconn->query($sql);
  $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $data = array();
  /****** FINISH - TABLE RECORDS AND FILTERING ******/
  
  if($facturas == FALSE)
  {
    // RESULT FALSE
    $result = FALSE;
  }
  else
  {
    // RESULT TRUE
    $result = TRUE;
    foreach ($facturas as $factura) {
        // SETTING UP COLUMNS FOR TABLE
        $row = array();

        $total = $factura['precio_venta'] * $factura['cantidad'];
    
       
        
        $row['codigo'] = $factura['codproducto'];  
        $row['nofactura'] = $factura['nofactura'];       
        $row['descripcion'] = $factura['descripcion'];
        $row['cantidad'] = $factura['cantidad'];  
        $row['precio'] = $factura['precio_venta'];   
        $row['total'] = $total;       
        $row['marca'] = $factura['marca'];        
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
