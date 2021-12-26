<?php
session_start();
include('../../conexion.php');

include('../core/config.php');
$dbconn = getConnection();



if ($_SESSION['idUser']) {
    // Check if the form was sent and the action is SAVE
    if (isset($_POST['accion']) and $_POST['accion'] == "insertacredito") {
        $result = 0;
        $stmt = $dbconn->query('SELECT IFNULL(MAX(id), 0)+1 AS numero FROM notacredito');
        $credito = $stmt->fetch(PDO::FETCH_ASSOC);
        $id = $credito['numero'];
        $fecha = date("Y-m-d H:i:s");
        $id_factura = $_POST['factura'];
        $motivo = $_POST['motivo'];
        $observacion = $_POST['observacion'];

        $usuario_id = $_SESSION['idUser'];



        try {

            // start transaction
            $dbconn->beginTransaction();

            $sql = 'INSERT INTO notacredito
                (id, fecha, usuario_id, nofactura, estado, motivo, observacion)
                VALUES
                (:id, :fecha, :usuario_id, :nofactura, 1, :motivo, :observacion)';

            $stmt = $dbconn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':nofactura', $id_factura);
            $stmt->bindParam(':motivo', $motivo);
            $stmt->bindParam(':observacion', $observacion);
            $stmt->execute();

            //TRAIGO EL ID DE PRODUCTO DE LA TABLA FACTURA
            $sql = 'SELECT codproducto, cantidad FROM detallefactura WHERE nofactura = :nofactura';
            $stmt = $dbconn->prepare($sql);
            $stmt->bindParam(':nofactura', $id_factura);
            $stmt->execute();
            $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //hacemos un ciclo para insertar los facturas
            foreach ($facturas as $factura) {
                $id_producto = $factura['codproducto'];
                $cantidad = $factura['cantidad'];

                $sql = 'INSERT INTO detalle_nota_credito
                (id_credito, id_producto, cantidad)    
                VALUES
                (:id_credito, :id_producto, :cantidad)';

                $stmt2 = $dbconn->prepare($sql);
                $stmt2->bindParam(':id_credito', $id );
                $stmt2->bindParam(':id_producto', $id_producto);
                $stmt2->bindParam(':cantidad', $cantidad);
                $stmt2->execute();

                //actualizamos el stock de los productos devueltos               
                $sql = 'UPDATE producto SET existencia = existencia + :cantidad 
                WHERE codproducto = :id_producto';
                $stmt4 = $dbconn->prepare($sql);
                $stmt4->bindParam(':cantidad', $cantidad);
                $stmt4->bindParam(':id_producto', $id_producto);
                $stmt4->execute();
            }

            //cambiamos el estado de la factura
            $estado = 2;
            $sql = 'UPDATE factura SET estado = :estado WHERE nofactura= :nofactura';
            $stmt3 = $dbconn->prepare($sql);            
            $stmt3->bindParam(':estado', $estado);
            $stmt3->bindParam(':nofactura', $id_factura);         
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
