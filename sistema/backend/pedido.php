<?php
session_start();
include('../../conexion.php');

include('../core/config.php');
$dbconn = getConnection();



if ($_SESSION['idUser']) {
    // Check if the form was sent and the action is SAVE
    if (isset($_POST['accion']) and $_POST['accion'] == "insertapedido") {
        $result = 0;
        $stmt = $dbconn->query('SELECT IFNULL(MAX(id), 0)+1 AS numero FROM pedido_compra');
        $pedidos = $stmt->fetch(PDO::FETCH_ASSOC);
        $pedido = $pedidos['numero'];
        $proveedor = $_POST['codproveedor'];
        $sucursal = $_POST['sucursal_id'];
        $usuario_id = $_SESSION['idUser'];
        $fecha = date("Y-m-d H:i:s");



        try {



            $sql = 'INSERT INTO pedido_compra
                (id, fecha, proveedor_id, sucursa_id, usuario_id)
					VALUES (:id, :fecha, :proveedor_id, :sucursa_id, :usuario_id)';
            $stmt = $dbconn->prepare($sql);
            // pass values to the statement
            $stmt->bindValue(':id', $pedido);
            $stmt->bindValue(':fecha', $fecha);
            $stmt->bindValue(':proveedor_id', $proveedor);
            $stmt->bindValue(':sucursa_id', $sucursal);
            $stmt->bindValue(':usuario_id', $usuario_id);
            // execute and get number of affected rows
            $result = $stmt->execute();
            $message = $result ? "Se inserto" : "Ocurrio un error intentado resolver la solicitud, " .
                "por favor complete todos los campos o recargue de vuelta la pagina ";

            $status = $result ? "success" : "error";
            print json_encode(array("status" => $status, "message" => $message));



            // HASta qui
        } catch (Exception $e) {
            $result = FALSE;
            var_dump($e->getMessage());
        }
    } else if (isset($_POST['accion']) and $_POST['accion'] == "insertadetalle") {
        $result = 0;
        $pedido = $_POST['pedido'];
        $producto = $_POST['producto'];
        $cantidad = $_POST['cantidad'];


        try {

            $stmt2 = $dbconn->prepare('SELECT * FROM detalle_pedido WHERE id_pedido = :id_pedido AND id_producto = :id_producto');
            $stmt2->bindValue(':id_pedido', $pedido);
            $stmt2->bindValue(':id_producto', $producto);
            $stmt2->execute();

            $detallepedido = $stmt2->fetch(PDO::FETCH_ASSOC);
            $codproducto = empty($detallepedido['id_producto']) ? 0 : $detallepedido['id_producto'];
            $cantidadpedido = empty($detallepedido['cantidad']) ? 0 : $detallepedido['cantidad'];


            if ($codproducto == 0) {
                $sql = 'INSERT INTO detalle_pedido
                (id_pedido, id_producto, cantidad)
                    VALUES (:id_pedido, :id_producto, :cantidad)';
                $stmt = $dbconn->prepare($sql);
                // pass values to the statement
                $stmt->bindValue(':id_pedido', $pedido);
                $stmt->bindValue(':id_producto', $producto);
                $stmt->bindValue(':cantidad', $cantidad);
                // execute and get number of affected rows
                $result = $stmt->execute();
                $message = $result ? "Se inserto" : "Ocurrio un error intentado resolver la solicitud, " .
                    "por favor complete todos los campos o recargue de vuelta la pagina ";

                $status = $result ? "success" : "error";
                print json_encode(array("status" => $status, "message" => $message));
            } else {

                $cantidadpedido = $cantidadpedido + $cantidad;
                $sql = 'UPDATE detalle_pedido SET cantidad = :cantidad WHERE id_pedido = :id_pedido AND id_producto = :id_producto';
                $stmt = $dbconn->prepare($sql);
                // pass values to the statement
                $stmt->bindValue(':id_pedido', $pedido);
                $stmt->bindValue(':id_producto', $producto);
                $stmt->bindValue(':cantidad', $cantidadpedido);
                // execute and get number of affected rows
                $result = $stmt->execute();
                $message = $result ? "Actualizo" : "Ocurrio un error intentado resolver la solicitud, " .
                    "por favor complete todos los campos o recargue de vuelta la pagina ";

                $status = $result ? "success" : "error";
                print json_encode(array("status" => $status, "message" => $message));
            }
        } catch (Exception $e) {
            $result = FALSE;
            var_dump($e->getMessage());
        }
    } else if (isset($_POST['accion']) and $_POST['accion'] == "eliminadetalle") {
        $result = 0;
        $pedido = $_POST['pedido'];
        $producto = $_POST['producto'];





        try {
            // start transaction
            $dbconn->beginTransaction();
            // entonces borramos los sitios anteriores guardados
            $stmt1 = $dbconn->prepare('SELECT * FROM detalle_pedido 
            WHERE id_pedido = :id_pedido AND id_producto = :id_producto');
            $stmt1->bindValue(":id_pedido", $pedido);
            $stmt1->bindValue(":id_producto", $producto);
            $stmt1->execute();
            $detalle_pedido = $stmt1->fetch(PDO::FETCH_ASSOC);
            // actualizamos la tabla usuarios
            $sql = 'DELETE FROM  detalle_pedido 
            WHERE id_pedido = :id_pedido AND id_producto = :id_producto';
            $stmt = $dbconn->prepare($sql);
            $stmt->bindValue(":id_pedido", $pedido);
            $stmt->bindValue(":id_producto", $producto);
            $result = $stmt->execute();
            // commit transaction
            $dbconn->commit();
        } catch (Exception $e) {
            $result = FALSE;
            // rollback transaction
            $dbconn->rollBack();
            var_dump($e->getMessage());
        }

        $message = $result ? "se borro" : "Ocurrio un error intentado resolver la solicitud, " .
            "por favor complete todos los campos o recargue de vuelta la pagina";

        $status = $result ? "success" : "error";
        print json_encode(array("status" => $status, "message" => $message));
    } else if (isset($_POST['accion']) and $_POST['accion'] == "cancelarpedido") {
        $result = 0;
        $pedido = $_POST['pedido'];      





        try {
            // start transaction
            $dbconn->beginTransaction();
            // entonces borramos los sitios anteriores guardados
            $sql = 'DELETE FROM  detalle_pedido 
            WHERE id_pedido = :id_pedido';
            $stmt = $dbconn->prepare($sql);
            $stmt->bindValue(":id_pedido", $pedido);         
            $result = $stmt->execute();
            // commit transaction
            $dbconn->commit();
        } catch (Exception $e) {
            $result = FALSE;
            // rollback transaction
            $dbconn->rollBack();
            var_dump($e->getMessage());
        }

        $message = $result ? "se borro" : "Ocurrio un error intentado resolver la solicitud, " .
            "por favor complete todos los campos o recargue de vuelta la pagina";

        $status = $result ? "success" : "error";
        print json_encode(array("status" => $status, "message" => $message));
    } else // FORM NOT SENT
    {
        print json_encode(array("status" => "error", "message" => "Formulario no enviado"));
    }
} else // NOT LOGGED
{
    print json_encode(array("status" => "error", "message" => "No autorizado"));
}
