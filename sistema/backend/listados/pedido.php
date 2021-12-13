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
    //$descripcion = $_GET['des'];



    /****** FINISH - VARIABLES DEFINITION ******/

    /****** BEGIN - FOR PAGINATION ******/
    // GET TOTAL
    $sql_total = "SELECT count(*) as total FROM pedido_compra WHERE 1=1";

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
    $sql = "SELECT id, fecha, proveedor_id, sucursa_id,  usuario_id, estado  from pedido_compra
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

            $proveedor_id = $pedido['proveedor_id'];
            $usuario_id = $pedido['usuario_id'];
            $sucursa_id = $pedido['sucursa_id'];
            //proveedor
            $stmt5 = $dbconn->query("SELECT * FROM proveedor WHERE codproveedor = $proveedor_id");
            $proveedor = $stmt5->fetch(PDO::FETCH_ASSOC);
            //usuario
            $stmt6 = $dbconn->query("SELECT * FROM usuario WHERE idusuario = $usuario_id");
            $usuario = $stmt6->fetch(PDO::FETCH_ASSOC);
            //sucursal
            $stmt7 = $dbconn->query("SELECT * FROM sucursal WHERE idsucursal = $sucursa_id");
            $sucursal = $stmt7->fetch(PDO::FETCH_ASSOC);
            //fecha
            $fecha = date("d/m/Y", strtotime($pedido['fecha']));



            $row['id'] = $pedido['id'];
            $row['fecha'] = $fecha;
            $row['proveedor'] = $proveedor['proveedor'];
            $row['sucursal'] = $sucursal['nombre'];
            $row['usuario'] = $usuario['nombre'];
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
