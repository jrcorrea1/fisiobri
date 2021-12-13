<?php
session_start();
include('../../conexion.php');

include('../core/config.php');
$dbconn = getConnection();



if ($_SESSION['idUser']) {
    // Check if the form was sent and the action is SAVE
    if (isset($_POST['accion']) and $_POST['accion'] == "apertura") {
        $result = 0;
        $stmt = $dbconn->query('SELECT IFNULL(MAX(id_caja), 0)+1 AS numero FROM apertura_cierre');
        $apertura = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_caja = $apertura['numero'];
        $fecha_apertura = date("Y-m-d H:i:s");
        $monto_apertura = $_POST['monto_apertura'];


        $usuario_id = $_SESSION['idUser'];
        // $fecha = date("Y-m-d H:i:s");



        try {
            $stmt2 = $dbconn->prepare("SELECT * FROM apertura_cierre WHERE usuario_id = :usuario_id");
            $stmt2->bindValue(":usuario_id", $usuario_id);
            $stmt2->execute();
            $verificarcaja = $stmt2->fetch(PDO::FETCH_ASSOC);
            if (!empty($verificarcaja['estado'] == true)) {
                $message = "Ya se encuetra caja abierta con este usuario";
                $status = "error";
                print json_encode(array("status" => $status, "message" => $message));
                exit();
            }



            $sql = 'INSERT INTO apertura_cierre
            (id_caja, fecha_apertura, monto_apertura,usuario_id, estado)
            VALUES
            (:id_caja, :fecha_apertura, :monto_apertura, :usuario_id, true)';

            $stmt = $dbconn->prepare($sql);

            $stmt->bindParam(':id_caja', $id_caja);
            $stmt->bindParam(':fecha_apertura', $fecha_apertura);
            $stmt->bindParam(':monto_apertura', $monto_apertura);
            $stmt->bindParam(':usuario_id', $usuario_id);
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
    } // realizamos un cierre de caja 
    else if (isset($_POST['accion']) and $_POST['accion'] == "cierre") {


        $id_caja = $_POST['id_caja'];
        $fecha_cierre = date("Y-m-d H:i:s");


        $usuario_id = $_SESSION['idUser'];

        //consultamos todos los cobros realizados por id de caja
        $sql = "SELECT monto FROM cobros WHERE id_apertura = '" . $id_caja . "'";
        $stmt3 = $dbconn->query($sql);
        $cobros = $stmt3->fetchAll(PDO::FETCH_ASSOC);

        // sumamos los cobros
        $totalCobros = 0;
        foreach ($cobros as $cobro) {
            $totalCobros += $cobro['monto'];
        }

        // consultamos monto de apertura
        $sql = "SELECT monto_apertura FROM apertura_cierre WHERE id_caja = '" . $id_caja . "'";
        $stmt4 = $dbconn->query($sql);
        $apertura = $stmt4->fetch(PDO::FETCH_ASSOC);

        $total = $totalCobros + $apertura['monto_apertura'];


        try {

            $sql = 'UPDATE apertura_cierre SET estado = false, fecha_cierre = :fecha_cierre, monto_cierre = :monto_cierre, estado=false WHERE id_caja = :id_caja';
            $stmt = $dbconn->prepare($sql);
            $stmt->bindParam(':id_caja', $id_caja);
            $stmt->bindParam(':fecha_cierre', $fecha_cierre);
            $stmt->bindParam(':monto_cierre', $total);
            $result = $stmt->execute();
            $message = $result ? "Se inserto" : "Ocurrio un error intentado resolver la solicitud, " .
                "por favor complete todos los campos o recargue de vuelta la pagina ";

            $status = $result ? "success" : "error";
            print json_encode(array("status" => $status, "message" => $message));
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
