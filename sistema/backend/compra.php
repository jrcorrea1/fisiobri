<?php
session_start();
include('../../conexion.php');

include('../core/config.php');
$dbconn = getConnection();



if ($_SESSION['idUser']) {
    // Check if the form was sent and the action is SAVE
    if (isset($_POST['accion']) and $_POST['accion'] == "comprasdetalles") {
        $result = 0;
        $stmt = $dbconn->query('SELECT IFNULL(MAX(id), 0)+1 AS numero FROM compra');
        $compra = $stmt->fetch(PDO::FETCH_ASSOC);
        $idcompra = $compra['numero'];
        $fecha = date("Y-m-d H:i:s");
        $pedido = $_POST['pedido'];
        $proveedor = $_POST['proveedor'];
        $sucursal = $_POST['sucursal'];

        $usuario_id = $_SESSION['idUser'];



        try {

            // start transaction
            $dbconn->beginTransaction();

            $sql = 'INSERT INTO compra
                (id, fecha, proveedor_id, sucursa_id, usuario_id, estado, pedido_id)    
                VALUES
                (:id, :fecha, :proveedor_id, :sucursa_id, :usuario_id, :estado, :pedido_id)';

            $stmt = $dbconn->prepare($sql);
            $stmt->bindParam(':id', $idcompra);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':proveedor_id', $proveedor);
            $stmt->bindParam(':sucursa_id', $sucursal);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':pedido_id', $pedido);
            $stmt->execute();

            //TRAIGO EL ID DE PRODUCTO DE LA TABLA PEDIDO_DETALLE
            $sql = 'SELECT id_producto, cantidad FROM detalle_pedido WHERE id_pedido = :id_pedido';
            $stmt = $dbconn->prepare($sql);
            $stmt->bindParam(':id_pedido', $pedido);
            $stmt->execute();
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //hacemos un ciclo para insertar los productos
            foreach ($productos as $producto) {
                $id_producto = $producto['id_producto'];
                $cantidad = $producto['cantidad'];

                $sql = 'INSERT INTO detalle_compra
                (id_compra, id_producto, cantidad)    
                VALUES
                (:id_compra, :id_producto, :cantidad)';

                $stmt2 = $dbconn->prepare($sql);
                $stmt2->bindParam(':id_compra', $idcompra);
                $stmt2->bindParam(':id_producto', $id_producto);
                $stmt2->bindParam(':cantidad', $cantidad);
                $stmt2->execute();

                //actualizamos el stock de los productos
                $sql = 'UPDATE producto SET existencia = existencia + :cantidad WHERE codproducto = :id_producto';
                $stmt4 = $dbconn->prepare($sql);
                $stmt4->bindParam(':cantidad', $cantidad);
                $stmt4->bindParam(':id_producto', $id_producto);
                $stmt4->execute();
            }

            //cambiamos el estado del pedido a compra
            $sql = 'UPDATE pedido_compra SET estado = :estado WHERE id = :id';
            $stmt3 = $dbconn->prepare($sql);
            $estado = 'Comprado';
            $stmt3->bindParam(':estado', $estado);
            $stmt3->bindParam(':id', $pedido);
            $stmt3->execute();

            


       








            

            // commit transaction
            $result = $dbconn->commit();


            $message = $result ? "Se inserto" : "Ocurrio un error intentado resolver la solicitud, " .
                "por favor complete todos los campos o recargue de vuelta la pagina ";

            $status = $result ? "success" : "error";
            print json_encode(array("status" => $status, "message" => $message));



            // HASta qui
        } catch (Exception $e) {
            $result = FALSE;
            var_dump($e->getMessage());
        }
    } else // FORM NOT SENT
    {
        print json_encode(array("status" => "error", "message" => "Formulario no enviado"));
    }
} else // NOT LOGGED
{
    print json_encode(array("status" => "error", "message" => "No autorizado"));
}
