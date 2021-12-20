<?php
session_start();
include('../../conexion.php');

include('../core/config.php');
$dbconn = getConnection();



if ($_SESSION['idUser']) {
    // Check if the form was sent and the action is SAVE
    if (isset($_POST['accion']) and $_POST['accion'] == "cobrar") {
        $result = 0;
        $factura = $_POST['factura'];
        $forma_cobro = $_POST['formacobro'];
        $monto = $_POST['monto'];
        $cliente = $_POST['cliente'];
        $apertura = $_POST['apertura'];
        $usuario_id = $_SESSION['idUser'];
        $fechacobro = date("Y-m-d H:i:s");
        $banco =  $forma_cobro == "Cheque" ? $_POST['banco'] : NULL;
        $cheque =  $forma_cobro == "Cheque" ? $_POST['cheque'] : NULL;

        try {
            $stmt2 = $dbconn->prepare("SELECT * FROM cobros WHERE factura = :factura");
            $stmt2->bindValue(":factura", $factura);
            $stmt2->execute();
            $verificocobro = $stmt2->fetch(PDO::FETCH_ASSOC);
            if (!empty($verificocobro['factura'])) {
                $message = "La factura ya esta cancelada!";
                $status = "error";
                print json_encode(array("status" => $status, "message" => $message));
                exit();
            }
            $sql = "INSERT INTO cobros (factura, formacobro, monto, cliente, id_apertura, usuario_id, fechacobro, banco, cheque) 
            VALUES (:factura, :forma_cobro, :monto, :cliente, :apertura, :usuario_id, :fechacobro, :banco, :cheque)";

            $stmt = $dbconn->prepare($sql);
            $stmt->bindValue(":factura", $factura);
            $stmt->bindValue(":forma_cobro", $forma_cobro);
            $stmt->bindValue(":monto", $monto);
            $stmt->bindValue(":cliente", $cliente);
            $stmt->bindValue(":apertura", $apertura);
            $stmt->bindValue(":usuario_id", $usuario_id);
            $stmt->bindValue(":fechacobro", $fechacobro);
            $stmt->bindValue(":banco", $banco);
            $stmt->bindValue(":cheque", $cheque);
            $result = $stmt->execute();
            $lastId = $dbconn->lastInsertId();

            $message = $result ? "Factura cobrada exitosamente" : " Error al efectuar el cobro";

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
